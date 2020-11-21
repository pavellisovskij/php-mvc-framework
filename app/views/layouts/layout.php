<!doctype html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title><?= $title ?></title>

        <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/dashboard/">

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="/">Штатное расписание</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="mainNavBar" aria-controls="mainNavBar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavBar">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <?php if (\app\lib\Auth::check()) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= \app\lib\Auth::username() ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/logout">Выйти</a>
                            </div>
                        </li>
                    <?php else : ?>
                        <li class="nav-item text-nowrap">
                            <a class="nav-link" href="/signin">Войти</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                    <div class="sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="/positions">
                                    <span data-feather="trello"></span>
                                    Должности
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/workplaces">
                                    <span data-feather="file-text"></span>
                                    Рабочие места
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/departments">
                                    <span data-feather="grid"></span>
                                    Отделы
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/employees">
                                    <span data-feather="users"></span>
                                    Сотрудники
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                        <h1 class="h2"><?= $title ?></h1>
                    </div>

                    <?php echo $content ?>
                </main>
            </div>
        </div>

        <!--Bootstrap core JavaScript-->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <!-- Icons -->
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script>
            feather.replace()
        </script>
    </body>
</html>