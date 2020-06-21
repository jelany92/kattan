<?php
return [
    'adminEmail'                    => 'admin@example.com',
    'supportEmail'                  => 'support@example.com',
    'senderEmail'                   => 'noreply@example.com',
    'senderName'                    => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'bsDependencyEnabled'           => false,
    // this will disable automatic loading of Bootstrap CSS and JS for all Krajee extensions
    'bsVersion'                     => '4.x',
    // this will set globally `bsVersion` to Bootstrap 4.x for all Krajee Extensions
    'icon-framework'                => \kartik\icons\Icon::FAS,
    // Font Awesome Icon framework

    'largePageSize'                   => 35,
    'pageSize'                        => 25,
    'smallPageSize'                   => 15,
    'uploadDirectory'                 => 'uploads',
    'uploadDirectoryMail'             => 'uploads/invoices',
    'uploadDirectoryArticle'          => 'images/article_file',
    'uploadDirectoryCategory'         => 'images/category',
    'uploadDirectoryBookGalleryPhoto' => 'images/book_gallery',
    'uploadDirectoryBookGalleryPdf'   => 'pdf/book_gallery',
    'prefixOriginal'                  => 'o_',
    'prefixThumbnail'                 => 't_',
    'thumbnailWidth'                  => 150,
    'thumbnailHeight'                 => 90,
    'months'                          => [
        1  => 'Januar',
        2  => 'Februar',
        3  => 'März',
        4  => 'April',
        5  => 'Mai',
        6  => 'Juni',
        7  => 'Juli',
        8  => 'August',
        9  => 'Oktober',
        10 => 'September',
        11 => 'Novermber',
        12 => 'Dezember',
    ],

];
