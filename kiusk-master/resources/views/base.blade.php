<!DOCTYPE HTML>
<html lang="fa"
      dir="rtl">
<head>
 <meta charset="utf-8">
 <meta name="viewport"
       content="width=device-width, initial-scale=1, shrink-to-fit=no">
 <meta name="keywords"
       content="htmlcss bootstrap, multi level menu, submenu, treeview nav menu examples"/>
 <meta name="description"
       content="Bootstrap 5 navbar multilevel treeview examples for any type of project, Bootstrap 5"/>
 <meta name="google-site-verification" content="bXOA3bmNxTV0meIss3APTsqNhNJ7pL8enADFsq1-ljQ" />
 <title>Demo - Bootstrap 5 multilevel dropdown submenu sample</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
       rel="stylesheet"
       crossorigin="anonymous">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
         crossorigin="anonymous"></script>
 <style type="text/css">
     /* ============ desktop view ============ */
     @media all and (min-width: 992px) {

         .dropdown-menu li {
             position: relative;
         }

         .dropdown-menu .submenu {
             display: none;
             position: absolute;
             left: 100%;
             top: -7px;
         }

         .dropdown-menu .submenu-left {
             right: 100%;
             left: auto;
         }

         .dropdown-menu > li:hover {
             background-color: #f1f1f1
         }

         .dropdown-menu > li:hover > .submenu {
             display: block;
         }
     }

     /* ============ desktop view .end// ============ */

     /* ============ small devices ============ */
     @media (max-width: 991px) {

         .dropdown-menu .dropdown-menu {
             margin-left: 0.7rem;
             margin-right: 0.7rem;
             margin-bottom: .5rem;
         }

     }

     /* ============ small devices .end// ============ */
 </style>
 <script type="text/javascript">
   //	window.addEventListener("resize", function() {
   //		"use strict"; window.location.reload();
   //	});
   document.addEventListener("DOMContentLoaded", function () {
     /////// Prevent closing from click inside dropdown
     document.querySelectorAll('.dropdown-menu').forEach(function (element) {
       element.addEventListener('click', function (e) {
         e.stopPropagation();
       });
     })
     // make it as accordion for smaller screens
     if (window.innerWidth < 992) {
       // close all inner dropdowns when parent is closed
       document.querySelectorAll('.navbar .dropdown').forEach(function (everydropdown) {
         everydropdown.addEventListener('hidden.bs.dropdown', function () {
           // after dropdown is hidden, then find all submenus
           this.querySelectorAll('.submenu').forEach(function (everysubmenu) {
             // hide every submenu as well
             everysubmenu.style.display = 'none';
           });
         })
       });
       document.querySelectorAll('.dropdown-menu a').forEach(function (element) {
         element.addEventListener('click', function (e) {
           let nextEl = this.nextElementSibling;
           if (nextEl && nextEl.classList.contains('submenu')) {
             // prevent opening link if link needs to open dropdown
             e.preventDefault();
             console.log(nextEl);
             if (nextEl.style.display == 'block') {
               nextEl.style.display = 'none';
             }
             else {
               nextEl.style.display = 'block';
             }
           }
         });
       })
     }
     // end if innerWidth
   });
   // DOMContentLoaded  end
 </script>
</head>
<body>
{{--<header class="section-header py-4">
 <div class="container">
  <h2>Demo page </h2>
 </div>
</header>--}} <!-- section-header.// -->
<div class="container pb-5">
@include('category_menu' )

<!-- ============= COMPONENT ============== -->
@yield('header')

<!-- ============= COMPONENT END// ============== -->
 @yield('content')
</div><!-- container //  -->
</body>
</html>
