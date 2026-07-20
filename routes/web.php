<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\Admin\ChatLogController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DocumentCategoryController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/tentang', [PageController::class, 'about'])->name('about');
Route::get('/layanan', [PageController::class, 'services'])->name('services.index');
Route::get('/layanan/{slug}', [PageController::class, 'serviceShow'])->name('services.show');
Route::get('/portofolio', [PageController::class, 'portfolio'])->name('portfolio.index');
Route::get('/portofolio/{slug}', [PageController::class, 'portfolioShow'])->name('portfolio.show');
Route::get('/klien', [PageController::class, 'clients'])->name('clients');
Route::get('/galeri', [PageController::class, 'gallery'])->name('gallery.index');
Route::get('/galeri/{slug}', [PageController::class, 'galleryShow'])->name('gallery.show');
Route::get('/berita', [PageController::class, 'news'])->name('news.index');
Route::get('/berita/{slug}', [PageController::class, 'newsShow'])->name('news.show');
Route::get('/dokumen', [PageController::class, 'documents'])->name('documents');
Route::get('/dokumen/{document}/unduh', [PageController::class, 'documentDownload'])->name('documents.download');
Route::get('/karir', [PageController::class, 'careers'])->name('careers');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');
Route::post('/kontak', [PageController::class, 'contactSubmit'])->name('contact.submit')->middleware('throttle:5,1');
Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');
Route::post('/api/chat', [ChatController::class, 'send'])->name('chat.send');

/*
|--------------------------------------------------------------------------
| Admin Panel (KGP CMS)
|--------------------------------------------------------------------------
*/
Route::prefix('kgp-panel')->name('panel.')->group(function () {

    Route::get('/masuk', [AuthController::class, 'show'])->name('login');
    Route::post('/masuk', [AuthController::class, 'attempt'])->name('login.attempt');
    Route::post('/keluar', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Konten profil & galeri — admin + superadmin.
        Route::middleware('role:admin')->group(function () {

            // Layanan
            Route::get('/layanan', [ServiceController::class, 'index'])->name('services.index');
            Route::get('/layanan/tambah', [ServiceController::class, 'create'])->name('services.create');
            Route::post('/layanan', [ServiceController::class, 'store'])->name('services.store');
            Route::get('/layanan/{service}/ubah', [ServiceController::class, 'edit'])->name('services.edit');
            Route::put('/layanan/{service}', [ServiceController::class, 'update'])->name('services.update');
            Route::delete('/layanan/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

            // Portofolio
            Route::get('/portofolio', [ProjectController::class, 'index'])->name('projects.index');
            Route::get('/portofolio/tambah', [ProjectController::class, 'create'])->name('projects.create');
            Route::post('/portofolio', [ProjectController::class, 'store'])->name('projects.store');
            Route::get('/portofolio/{project}/ubah', [ProjectController::class, 'edit'])->name('projects.edit');
            Route::put('/portofolio/{project}', [ProjectController::class, 'update'])->name('projects.update');
            Route::delete('/portofolio/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
            Route::delete('/portofolio/{project}/foto/{image}', [ProjectController::class, 'destroyPhoto'])->name('projects.photos.destroy');
            Route::patch('/portofolio/{project}/foto/{image}/cover', [ProjectController::class, 'setCover'])->name('projects.photos.cover');

            // Klien
            Route::get('/klien', [ClientController::class, 'index'])->name('clients.index');
            Route::get('/klien/tambah', [ClientController::class, 'create'])->name('clients.create');
            Route::post('/klien', [ClientController::class, 'store'])->name('clients.store');
            Route::get('/klien/{client}/ubah', [ClientController::class, 'edit'])->name('clients.edit');
            Route::put('/klien/{client}', [ClientController::class, 'update'])->name('clients.update');
            Route::delete('/klien/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');

            // Galeri
            Route::get('/galeri', [GalleryController::class, 'index'])->name('galleries.index');
            Route::get('/galeri/tambah', [GalleryController::class, 'create'])->name('galleries.create');
            Route::post('/galeri', [GalleryController::class, 'store'])->name('galleries.store');
            Route::get('/galeri/{gallery}/ubah', [GalleryController::class, 'edit'])->name('galleries.edit');
            Route::put('/galeri/{gallery}', [GalleryController::class, 'update'])->name('galleries.update');
            Route::delete('/galeri/{gallery}', [GalleryController::class, 'destroy'])->name('galleries.destroy');
            Route::get('/galeri/{gallery}/foto', [GalleryController::class, 'photos'])->name('galleries.photos');
            Route::post('/galeri/{gallery}/foto', [GalleryController::class, 'storePhotos'])->name('galleries.photos.store');
            Route::put('/galeri/{gallery}/foto', [GalleryController::class, 'updatePhotos'])->name('galleries.photos.update');
            Route::delete('/galeri/{gallery}/foto/{photo}', [GalleryController::class, 'destroyPhoto'])->name('galleries.photos.destroy');
        });

        // Berita — admin, editor + superadmin.
        Route::middleware('role:admin,editor')->group(function () {

            Route::get('/berita', [PostController::class, 'index'])->name('posts.index');
            Route::get('/berita/tambah', [PostController::class, 'create'])->name('posts.create');
            Route::post('/berita', [PostController::class, 'store'])->name('posts.store');
            Route::get('/berita/{post}/ubah', [PostController::class, 'edit'])->name('posts.edit');
            Route::put('/berita/{post}', [PostController::class, 'update'])->name('posts.update');
            Route::delete('/berita/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

            Route::get('/berita-kategori', [PostCategoryController::class, 'index'])->name('post-categories.index');
            Route::post('/berita-kategori', [PostCategoryController::class, 'store'])->name('post-categories.store');
            Route::put('/berita-kategori/{postCategory}', [PostCategoryController::class, 'update'])->name('post-categories.update');
            Route::delete('/berita-kategori/{postCategory}', [PostCategoryController::class, 'destroy'])->name('post-categories.destroy');

            Route::get('/berita-tag', [TagController::class, 'index'])->name('tags.index');
            Route::post('/berita-tag', [TagController::class, 'store'])->name('tags.store');
            Route::delete('/berita-tag/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');
        });

        // Dokumen, karir & chatbot — admin + superadmin.
        Route::middleware('role:admin')->group(function () {

            Route::get('/dokumen', [DocumentController::class, 'index'])->name('documents.index');
            Route::get('/dokumen/tambah', [DocumentController::class, 'create'])->name('documents.create');
            Route::post('/dokumen', [DocumentController::class, 'store'])->name('documents.store');
            Route::get('/dokumen/{document}/ubah', [DocumentController::class, 'edit'])->name('documents.edit');
            Route::put('/dokumen/{document}', [DocumentController::class, 'update'])->name('documents.update');
            Route::delete('/dokumen/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');

            Route::get('/dokumen-kategori', [DocumentCategoryController::class, 'index'])->name('document-categories.index');
            Route::post('/dokumen-kategori', [DocumentCategoryController::class, 'store'])->name('document-categories.store');
            Route::put('/dokumen-kategori/{documentCategory}', [DocumentCategoryController::class, 'update'])->name('document-categories.update');
            Route::delete('/dokumen-kategori/{documentCategory}', [DocumentCategoryController::class, 'destroy'])->name('document-categories.destroy');

            Route::get('/karir', [CareerController::class, 'index'])->name('careers.index');
            Route::get('/karir/tambah', [CareerController::class, 'create'])->name('careers.create');
            Route::post('/karir', [CareerController::class, 'store'])->name('careers.store');
            Route::get('/karir/{career}/ubah', [CareerController::class, 'edit'])->name('careers.edit');
            Route::put('/karir/{career}', [CareerController::class, 'update'])->name('careers.update');
            Route::delete('/karir/{career}', [CareerController::class, 'destroy'])->name('careers.destroy');

            Route::get('/faq-chatbot', [FaqController::class, 'index'])->name('faqs.index');
            Route::get('/faq-chatbot/tambah', [FaqController::class, 'create'])->name('faqs.create');
            Route::post('/faq-chatbot', [FaqController::class, 'store'])->name('faqs.store');
            Route::get('/faq-chatbot/{faq}/ubah', [FaqController::class, 'edit'])->name('faqs.edit');
            Route::put('/faq-chatbot/{faq}', [FaqController::class, 'update'])->name('faqs.update');
            Route::delete('/faq-chatbot/{faq}', [FaqController::class, 'destroy'])->name('faqs.destroy');

            Route::get('/log-chatbot', [ChatLogController::class, 'index'])->name('chatlogs.index');
            Route::get('/log-chatbot/{conversation}', [ChatLogController::class, 'show'])->name('chatlogs.show');

            // Pesan Masuk (formulir kontak)
            Route::get('/pesan', [ContactMessageController::class, 'index'])->name('messages.index');
            Route::get('/pesan/{contactMessage}', [ContactMessageController::class, 'show'])->name('messages.show');
            Route::delete('/pesan/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');
        });

        // users & settings — superadmin.
        Route::middleware('role:superadmin')->group(function () {

            Route::get('/pengaturan', [SettingController::class, 'edit'])->name('settings.edit');
            Route::put('/pengaturan', [SettingController::class, 'update'])->name('settings.update');

            Route::get('/admin-users', [UserController::class, 'index'])->name('users.index');
            Route::get('/admin-users/tambah', [UserController::class, 'create'])->name('users.create');
            Route::post('/admin-users', [UserController::class, 'store'])->name('users.store');
            Route::get('/admin-users/{user}/ubah', [UserController::class, 'edit'])->name('users.edit');
            Route::put('/admin-users/{user}', [UserController::class, 'update'])->name('users.update');
            Route::delete('/admin-users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        });
    });
});

