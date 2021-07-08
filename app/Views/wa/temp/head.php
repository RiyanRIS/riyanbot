<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="riyanris">
    <title><?= (@$title?:"Dokumentasi") ?> | Whatsapp API</title>

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="https://i.ibb.co/BzNVj8K/logo.png" sizes="180x180">
    <link rel="icon" href="https://i.ibb.co/BzNVj8K/logo.png">
    <style>
      
      tr.loading {
        background-image: linear-gradient(to right, transparent 50%, rgba(0, 0, 0, .05) 50%);
        background-size: 200% 100%;
        animation: loading 2s cubic-bezier(0.4, 0, 0.2, 1) infinite;
      }

      tr.loading td {
        opacity: .45;
        pointer-events: none;
      }

      @keyframes loading {
        0% {
          background-position: 0;
        }
        50% {
          background-position: -30%;
        }
        80% {
          background-position: -100%;
        }
        100% {
          background-position: -200%;
        }
      }

      /* #updateUser, #cancelUpdate { */
      /* #isupdate {
        display: none;
      } */

      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    <link href="https://getbootstrap.com/docs/5.0/examples/sticky-footer-navbar/sticky-footer-navbar.css" rel="stylesheet">