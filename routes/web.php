<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController; // <-- Added

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Auth::routes();



Route::get('/test-mail', function () {
    Mail::raw('Test email from Laravel', function ($message) {
        $message->to('your-test-email@example.com')
            ->subject('Test Email');
    });
    return 'Email sent!';
});


// ---------------------- Categories ----------------------
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');

Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

// ---------------------- Tags ----------------------
Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
Route::get('/tags/{tag}', [TagController::class, 'show'])->name('tags.show');
Route::get('/tags/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit');

Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
Route::put('/tags/{tag}', [TagController::class, 'update'])->name('tags.update');
Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');

// ---------------------- Documents ----------------------
Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');

Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');

// ---------------------- Settings ----------------------
Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

// ---------------------- Language & Home ----------------------
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);
Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

// ---------------------- User Profile ----------------------
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

// ---------------------- Users Resource (Protected) ----------------------
Route::group(['middleware' => ['auth']], function () {
    Route::resource('users', UserController::class);

    Route::get('/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
    Route::post('/roles', [App\Http\Controllers\RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{id}/edit', [App\Http\Controllers\RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('roles.destroy');
});

// Route::group(['middleware' => ['auth']], function () {
//     Route::prefix('admin')->group(function () {
//         Route::resource('users', UserController::class);
//     });
// });

Route::get('/privacy_policy', function () {
    return <<<'HTML'
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Privacy Policy - Document Upload Service</title>
        <style>
            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
                line-height: 1.6;
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
                color: #333;
            }
            h1 {
                color: #2c3e50;
                border-bottom: 3px solid #3498db;
                padding-bottom: 10px;
            }
            h2 {
                color: #34495e;
                margin-top: 30px;
            }
            .last-updated {
                color: #7f8c8d;
                font-style: italic;
            }
            .container {
                background: #fff;
                padding: 30px;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Privacy Policy</h1>
            <p class="last-updated">Last updated: December 19, 2025</p>

            <p>This Privacy Policy describes how we collect, use, and protect your information when you use our document uploading service.</p>

            <h2>1. Information We Collect</h2>
            <h3>1.1 Account Information</h3>
            <p>When you create an account, we collect:</p>
            <ul>
                <li>Name and email address</li>
                <li>Password (encrypted)</li>
                <li>Account preferences and settings</li>
            </ul>

            <h3>1.2 Document Information</h3>
            <p>When you upload documents, we collect:</p>
            <ul>
                <li>Document files and their contents</li>
                <li>File names, sizes, and formats</li>
                <li>Upload timestamps</li>
                <li>Document metadata</li>
            </ul>

            <h3>1.3 Usage Information</h3>
            <p>We automatically collect:</p>
            <ul>
                <li>IP address and device information</li>
                <li>Browser type and version</li>
                <li>Pages visited and features used</li>
                <li>Access times and frequency</li>
            </ul>

            <h2>2. How We Use Your Information</h2>
            <p>We use your information to:</p>
            <ul>
                <li>Provide and maintain the document upload service</li>
                <li>Store and manage your uploaded documents</li>
                <li>Process and organize your files</li>
                <li>Improve our service and user experience</li>
                <li>Send important service updates and notifications</li>
                <li>Detect and prevent fraud or abuse</li>
                <li>Comply with legal obligations</li>
            </ul>

            <h2>3. Document Storage and Security</h2>
            <h3>3.1 Storage</h3>
            <p>Your documents are stored on secure servers with:</p>
            <ul>
                <li>Encryption at rest and in transit (SSL/TLS)</li>
                <li>Regular security audits and monitoring</li>
                <li>Redundant backups to prevent data loss</li>
                <li>Access controls and authentication</li>
            </ul>

            <h3>3.2 Document Access</h3>
            <p>Your documents are private by default. We do not:</p>
            <ul>
                <li>View or read your documents without permission</li>
                <li>Share your documents with third parties</li>
                <li>Use your documents for training AI models</li>
                <li>Sell or rent your data to anyone</li>
            </ul>

            <h2>4. Data Sharing and Disclosure</h2>
            <p>We may share your information only in these circumstances:</p>
            <ul>
                <li><strong>With your consent:</strong> When you explicitly authorize sharing</li>
                <li><strong>Service providers:</strong> Trusted partners who help operate our service (cloud storage, hosting)</li>
                <li><strong>Legal requirements:</strong> When required by law, court order, or legal process</li>
                <li><strong>Business transfers:</strong> In the event of a merger, acquisition, or sale of assets</li>
                <li><strong>Safety and security:</strong> To protect rights, property, or safety of users</li>
            </ul>

            <h2>5. Your Rights and Choices</h2>
            <p>You have the right to:</p>
            <ul>
                <li><strong>Access:</strong> Request a copy of your personal data</li>
                <li><strong>Correction:</strong> Update or correct your information</li>
                <li><strong>Deletion:</strong> Request deletion of your account and documents</li>
                <li><strong>Download:</strong> Export your documents at any time</li>
                <li><strong>Opt-out:</strong> Unsubscribe from marketing communications</li>
            </ul>

            <h2>6. Document Retention</h2>
            <p>We retain your documents and data:</p>
            <ul>
                <li>For as long as your account is active</li>
                <li>Until you delete them from your account</li>
                <li>For 30 days after account deletion (recovery period)</li>
                <li>Backups may persist for up to 90 days</li>
            </ul>

            <h2>7. Cookies and Tracking</h2>
            <p>We use cookies and similar technologies to:</p>
            <ul>
                <li>Keep you logged in</li>
                <li>Remember your preferences</li>
                <li>Analyze site usage and performance</li>
                <li>Improve security</li>
            </ul>
            <p>You can control cookies through your browser settings.</p>

            <h2>8. Third-Party Services</h2>
            <p>Our service may use third-party providers for:</p>
            <ul>
                <li>Cloud storage infrastructure</li>
                <li>Analytics and monitoring</li>
                <li>Payment processing</li>
                <li>Email delivery</li>
            </ul>
            <p>These providers have their own privacy policies governing their use of your information.</p>

            <h2>9. Children's Privacy</h2>
            <p>Our service is not intended for users under 13 years of age. We do not knowingly collect information from children. If you believe a child has provided us with personal information, please contact us.</p>

            <h2>10. International Data Transfers</h2>
            <p>Your data may be transferred to and processed in countries other than your own. We ensure appropriate safeguards are in place to protect your information in accordance with this Privacy Policy.</p>

            <h2>11. Changes to This Policy</h2>
            <p>We may update this Privacy Policy periodically. We will notify you of significant changes by:</p>
            <ul>
                <li>Posting the new policy on this page</li>
                <li>Updating the "Last updated" date</li>
                <li>Sending you an email notification (for material changes)</li>
            </ul>

            <h2>12. Contact Us</h2>
            <p>If you have questions about this Privacy Policy or our practices, please contact us at:</p>
            <ul>
                <li>Email: privacy@yourapp.com</li>
                <li>Address: [Your Company Address]</li>
            </ul>

            <hr style="margin: 40px 0; border: none; border-top: 1px solid #ddd;">

            <p style="text-align: center; color: #7f8c8d; font-size: 14px;">
                By using our document upload service, you agree to this Privacy Policy.
            </p>
        </div>
    </body>
    </html>
    HTML;
});

Route::get('/account_deletion', function () {
    return <<<'HTML'
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Account Deletion - Document Upload Service</title>
        <style>
            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
                line-height: 1.6;
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
                color: #333;
                background: #f5f5f5;
            }
            .container {
                background: #fff;
                padding: 40px;
                border-radius: 8px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }
            h1 {
                color: #c0392b;
                border-bottom: 3px solid #e74c3c;
                padding-bottom: 10px;
            }
            h2 {
                color: #34495e;
                margin-top: 30px;
            }
            .warning-box {
                background: #fff3cd;
                border-left: 4px solid #ffc107;
                padding: 15px;
                margin: 20px 0;
                border-radius: 4px;
            }
            .warning-box strong {
                color: #856404;
            }
            .info-box {
                background: #d1ecf1;
                border-left: 4px solid #17a2b8;
                padding: 15px;
                margin: 20px 0;
                border-radius: 4px;
            }
            .steps {
                background: #f8f9fa;
                padding: 20px;
                border-radius: 6px;
                margin: 20px 0;
            }
            .step {
                margin: 15px 0;
                padding-left: 30px;
                position: relative;
            }
            .step::before {
                content: "→";
                position: absolute;
                left: 0;
                color: #3498db;
                font-weight: bold;
                font-size: 20px;
            }
            ul {
                margin: 10px 0;
                padding-left: 20px;
            }
            ul li {
                margin: 8px 0;
            }
            .contact-section {
                background: #e8f5e9;
                padding: 20px;
                border-radius: 6px;
                margin-top: 30px;
            }
            .button {
                display: inline-block;
                background: #e74c3c;
                color: white;
                padding: 12px 30px;
                text-decoration: none;
                border-radius: 5px;
                font-weight: bold;
                margin: 20px 0;
                transition: background 0.3s;
            }
            .button:hover {
                background: #c0392b;
            }
            .timeline {
                background: #f8f9fa;
                padding: 15px;
                border-left: 3px solid #3498db;
                margin: 20px 0;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Account Deletion</h1>

            <p>We're sorry to see you go. This page explains how to delete your account and what happens to your data.</p>

            <div class="warning-box">
                <strong>⚠️ Warning:</strong> Account deletion is permanent and cannot be undone. All your data will be permanently deleted.
            </div>

            <h2>How to Delete Your Account</h2>

            <div class="steps">
                <h3>Option 1: Delete via Mobile App</h3>
                <div class="step">Open the app on your device</div>
                <div class="step">Go to <strong>Settings</strong> or <strong>Profile</strong></div>
                <div class="step">Tap on <strong>Account Settings</strong></div>
                <div class="step">Scroll down and tap <strong>Delete Account</strong></div>
                <div class="step">Confirm your decision by entering your password</div>
                <div class="step">Tap <strong>Delete My Account Permanently</strong></div>
            </div>

            <div class="steps">
                <h3>Option 2: Request Deletion via Email</h3>
                <p>If you're unable to access the app, send an email to:</p>
                <p><strong>Email:</strong> <a href="mailto:support@yourapp.com">support@yourapp.com</a></p>
                <p><strong>Subject:</strong> Account Deletion Request</p>
                <p><strong>Include:</strong></p>
                <ul>
                    <li>Your registered email address</li>
                    <li>Your account username (if applicable)</li>
                    <li>Confirmation that you want to permanently delete your account</li>
                </ul>
                <p>We will process your request within <strong>7 business days</strong>.</p>
            </div>

            <h2>What Gets Deleted</h2>
            <p>When you delete your account, the following information will be permanently removed:</p>
            <ul>
                <li><strong>Personal Information:</strong> Name, email, phone number, profile picture</li>
                <li><strong>All Uploaded Documents:</strong> Every document you've uploaded will be permanently deleted</li>
                <li><strong>Account Settings:</strong> All preferences and customizations</li>
                <li><strong>Upload History:</strong> Complete history of your uploads and activities</li>
                <li><strong>Shared Links:</strong> Any sharing links you've created</li>
                <li><strong>App Data:</strong> All data associated with your account</li>
            </ul>

            <h2>Data Retention After Deletion</h2>

            <div class="timeline">
                <p><strong>Immediate:</strong> Your account becomes inaccessible and you're logged out from all devices</p>
                <p><strong>Within 24 hours:</strong> Your data is removed from active systems</p>
                <p><strong>Within 30 days:</strong> Complete removal from all backups and recovery systems</p>
                <p><strong>Up to 90 days:</strong> Some data may remain in encrypted backup archives for disaster recovery purposes only</p>
            </div>

            <div class="info-box">
                <strong>Note:</strong> We may retain certain information if required by law, for legal proceedings, to prevent fraud, or to resolve disputes. This is limited to the minimum necessary data and timeframe.
            </div>

            <h2>What Happens After Deletion</h2>
            <ul>
                <li>You will <strong>not</strong> be able to recover your account</li>
                <li>You will <strong>not</strong> be able to recover any documents or data</li>
                <li>All shared links will become invalid</li>
                <li>You will need to create a new account if you want to use the service again</li>
                <li>Your email address can be reused for a new account after 30 days</li>
            </ul>

            <h2>Before You Delete</h2>
            <div class="warning-box">
                <strong>Consider These Alternatives:</strong>
                <ul style="margin-top: 10px;">
                    <li>Download all your documents first (available in app settings)</li>
                    <li>Delete individual documents instead of your entire account</li>
                    <li>Take a break - you can simply stop using the app without deleting</li>
                    <li>Contact support if you're having issues - we're here to help</li>
                </ul>
            </div>

            <h2>Download Your Data First</h2>
            <p>Before deleting your account, you can download all your data:</p>
            <div class="step">Open the app</div>
            <div class="step">Go to <strong>Settings</strong> → <strong>Account</strong></div>
            <div class="step">Tap <strong>Download My Data</strong></div>
            <div class="step">Wait for the export to complete (you'll receive an email)</div>
            <div class="step">Download the archive within 48 hours</div>

            <h2>Account Deletion for Deceased Users</h2>
            <p>If you need to request deletion of an account belonging to a deceased person, please contact us at <a href="mailto:support@yourapp.com">support@yourapp.com</a> with:</p>
            <ul>
                <li>Proof of death (death certificate)</li>
                <li>Proof of authority (executor documentation or legal authorization)</li>
                <li>The deceased person's account information</li>
            </ul>

            <div class="contact-section">
                <h2>Need Help?</h2>
                <p>If you have questions about account deletion or need assistance:</p>
                <p><strong>Email:</strong> <a href="mailto:support@yourapp.com">support@yourapp.com</a></p>
                <p><strong>Response Time:</strong> Within 24-48 hours</p>
                <p><strong>Phone:</strong> [Your Support Number] (if available)</p>
                <p><strong>Hours:</strong> Monday - Friday, 9:00 AM - 5:00 PM (Your Timezone)</p>
            </div>

            <hr style="margin: 40px 0; border: none; border-top: 1px solid #ddd;">

            <p style="text-align: center; color: #7f8c8d; font-size: 14px;">
                This page complies with Google Play Store account deletion requirements.<br>
                Last updated: December 19, 2025
            </p>
        </div>
    </body>
    </html>
    HTML;
});


// ---------------------- Catch-all route (Always LAST) ----------------------
// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])
//     ->where('any', '.*')
//     ->name('index');



