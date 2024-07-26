<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
    <style>
        @font-face {
            font-family: iransans;
            src: url({{ public_path() }}/font/IRANSansWeb.woff2);
            /*src: url(../../font/FontsFree-Net-ir_sans\ \(1\).ttf);*/
        }

        @font-face {
            font-family: Calibri;
            src: url({{ public_path() }}/font/calibri/calibri-regular.ttf);
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: Calibri;
            src: url({{ public_path() }}/font/calibri/calibri-italic.ttf);
            font-weight: normal;
            font-style: italic;
        }

        @font-face {
            font-family: Calibri;
            src: url({{ public_path() }}'/font/calibri/calibri-bold.ttf') format('woff2');
            font-weight: bold;
            font-style: normal;
        }

        @font-face {
            font-family: Calibri;
            src: url({{ public_path() }}'/font/calibri/calibri-bold-italic.ttf') format('woff2');
            font-weight: bold;
            font-style: italic;
        }
    </style>
    @if (App::isLocale('fa'))
        <style>
            * {
                padding: 0;
                box-sizing: border-box;
                list-style-type: none;
                outline: none;
                font-family: iransans, Calibri, sans-serif;
            }

            body {
                width: 100%;
                overflow-x: hidden;
                direction: rtl;
            }
        </style>
    @else
        <style>
            * {
                padding: 0;
                box-sizing: border-box;
                list-style-type: none;
                outline: none;
                font-family: Calibri, sans-serif;
            }

            body {
                width: 100%;
                overflow-x: hidden;
                direction: ltr;
            }
        </style>
    @endif
    <style>
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        h1 a {
            color: #212483 !important;
            line-height: 1.5;
            font-size: 1.5em;
        }

        h2 {
            font-size: 20px !important;
            font-weight: normal;
        }

        .w-75 {
            width: 75%;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        p {
            font-weight: normal;
            line-height: 21px;
            margin-bottom: 1rem !important;
            font-size: 14px;
        }

        .container,
        .container-fluid,
        .container-xxl,
        .container-xl,
        .container-lg,
        .container-md,
        .container-sm {
            width: 100%;
            padding-left: var(--bs-gutter-x, 0.75rem);
            padding-right: var(--bs-gutter-x, 0.75rem);
            margin-left: auto;
            margin-right: auto;
        }

        .image-header {
            width: 100%;
        }

        @media (min-width: 576px) {

            .container-sm,
            .container {
                max-width: 540px;
            }
        }

        @media (min-width: 768px) {

            .image-header {
                width: 75%;
            }

            .container-md,
            .container-sm,
            .container {
                max-width: 620px;
            }
        }

        @media (min-width: 992px) {

            .container-lg,
            .container-md,
            .container-sm,
            .container {
                max-width: 620px;
            }

            .image-header {
                width: 100%
            }
        }

        @media (min-width: 1200px) {

            .container-xl,
            .container-lg,
            .container-md,
            .container-sm,
            .container {
                max-width: 620px;
            }
        }

        @media (min-width: 1400px) {

            .container-xxl,
            .container-xl,
            .container-lg,
            .container-md,
            .container-sm,
            .container {
                max-width: 620px;
            }
        }

        .text-danger {
            color: rgba(220, 53, 69, 1) !important;
        }

        .text-primary {
            color: rgba(13, 110, 253, 1) !important;
        }

        .text-center {
            text-align: center !important;
        }
    </style>

    <style>
        @media only screen and (max-width: 480px) {
            p {
                font-weight: normal;
                line-height: 21px;
                margin-bottom: 1rem !important;
                font-size: 12px;
            }

            .top-heder-left-rebon {
                width: 30%;
            }

            .top-heder-right-rebon {
                width: 30%;
            }

            .top-heder-image {
                width: 100%;
            }

            .mobile-image {
                width: 100% !important;
                /* Make the image 100% width on mobile */
                padding-left: 0 !important;
                /* Remove horizontal padding on mobile */
                padding-right: 0 !important;
                /* Remove horizontal padding on mobile */
            }

            .title-wrapper {
                height: 20em !important;
            }

            .mobile-center {
                text-align: center !important;
                /* Center the content on mobile */
            }

            table[width="50%"] {
                width: 100% !important;
                /* Expand the table to full width on mobile */
                padding: 0;
                /* Remove padding on mobile */
            }

            td[style*="width: 25%"] {
                width: 25% !important;
                /* Make each cell 100% width on mobile */
            }
        }
    </style>
</head>
