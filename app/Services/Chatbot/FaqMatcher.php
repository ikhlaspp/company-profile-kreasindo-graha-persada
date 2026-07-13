<?php

namespace App\Services\Chatbot;

use App\Models\Faq;
use Illuminate\Support\Str;

/**
 * Matches an incoming message against active FAQ entries.
 *
 * Utilizes a lightweight keyword and word-overlap scoring heuristic
 * without requiring external API calls.
 */
class FaqMatcher
{
    /**
     * @var array<int, string>
     */
    private const STOP_WORDS = [
        'yang', 'untuk', 'dari', 'dengan', 'pada', 'adalah', 'apa', 'apakah',
        'bagaimana', 'dimana', 'di', 'ke', 'dan', 'atau', 'saya', 'kami', 'anda',
        'ada', 'bisa', 'mau', 'ingin', 'tentang', 'the', 'and', 'for', 'are', 'you',
    ];

    /**
     * FaqMatcher constructor.
     *
     * @param int $threshold The minimum score required for a match.
     */
    public function __construct(private readonly int $threshold = 2) {}

    /**
     * Finds the best-matching active FAQ entry.
     *
     * @param string $message The incoming user message.
     * @return Faq|null The best matching FAQ or null if the score is below the threshold.
     */
    public function match(string $message): ?Faq
    {
        $normalized = $this->normalize($message);

        if ($normalized === '') {
            return null;
        }

        $tokens = $this->tokens($normalized);

        $best = null;
        $bestScore = 0;

        foreach (Faq::where('is_active', true)->get() as $faq) {
            $score = $this->score($faq, $normalized, $tokens);

            if ($score > $bestScore) {
                $bestScore = $score;
                $best = $faq;
            }
        }

        return $bestScore >= $this->threshold ? $best : null;
    }

    /**
     * Calculates the relevance score for a given FAQ entry.
     *
     * @param Faq $faq The FAQ entry to score against.
     * @param string $message The normalized user message.
     * @param array<int, string> $tokens The filtered tokens from the user message.
     * @return int The calculated score.
     */
    private function score(Faq $faq, string $message, array $tokens): int
    {
        $score = 0;

        foreach ($this->splitKeywords($faq->keywords) as $keyword) {
            if ($keyword !== '' && preg_match('/\b'.preg_quote($keyword, '/').'\b/u', $message) === 1) {
                $score += 2;
            }
        }

        $questionTokens = $this->tokens($this->normalize($faq->question));
        $overlap = array_intersect($tokens, $questionTokens);
        $score += count($overlap);

        $normalizedQuestion = $this->normalize($faq->question);
        if ($normalizedQuestion !== '' && (Str::contains($message, $normalizedQuestion) || Str::contains($normalizedQuestion, $message))) {
            $score += 5;
        }

        return $score;
    }

    /**
     * Normalizes a string by converting to lowercase and stripping special characters.
     *
     * @param string $value
     * @return string
     */
    private function normalize(string $value): string
    {
        $value = Str::lower($value);
        $value = preg_replace('/[^\p{L}\p{N}\s]+/u', ' ', $value) ?? '';

        return trim(preg_replace('/\s+/', ' ', $value) ?? '');
    }

    /**
     * Tokenizes a normalized string, filtering out short words and stop words.
     *
     * @param string $normalized
     * @return array<int, string>
     */
    private function tokens(string $normalized): array
    {
        return collect(explode(' ', $normalized))
            ->filter(fn (string $w) => Str::length($w) >= 3 && ! in_array($w, self::STOP_WORDS, true))
            ->unique()
            ->values()
            ->all();
    }

    /**
     * Splits a comma-separated string of keywords into an array.
     *
     * @param string|null $keywords
     * @return array<int, string>
     */
    private function splitKeywords(?string $keywords): array
    {
        if (! $keywords) {
            return [];
        }

        return collect(explode(',', Str::lower($keywords)))
            ->map(fn (string $k) => trim($k))
            ->filter()
            ->all();
    }
}
