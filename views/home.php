<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="styles/base.css">
    <link rel="stylesheet" href="styles/styles.css">
    <script src="scripts/jquery.min.js"></script>
    <script src="scripts/scripts.js"></script>
</head>
<body>
<div class="page-container">
    <div class="header-container">
        <p id="error-message" class="error"></p>
        <button id="clear-lists" class="submit-button">Clear</button>
    </div>
    <div class="form-container">
        <div>
            <form id="cat-form" class="animal-form">
                <h2 class="form-heading">Cat</h2>
                <div class="form-input">
                    <label for="cat-name"></label>
                    <input id="cat-name"
                           type="text"
                           placeholder="Name"
                           name="name"
                           class="input-name"
                    />
                    <button class="submit-button">Add</button>
                </div>
            </form>
            <ol id="cat-list" class="animal-list"></ol>
        </div>

        <div>
            <form id="dog-form" class="animal-form">
                <h2 class="form-heading">Dog</h2>
                <div class="form-input">
                    <label for="dog-name"></label>
                    <input id="dog-name"
                           type="text"
                           placeholder="Name"
                           name="name"
                           class="input-name"
                    />
                    <button class="submit-button">Add</button>
                </div>
            </form>
            <ol id="dog-list" class="animal-list"></ol>
        </div>
    </div>
</div>
</body>
</html>