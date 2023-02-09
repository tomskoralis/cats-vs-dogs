let animals = [];
let catCount = 0;
let dogCount = 0;

$(document).ready(() => {
    $('#cat-form').submit((e) => {
        e.preventDefault();
        setErrorMessage('');
        storeAnimal('cat', $('#cat-name').val().trim());
    });

    $('#dog-form').submit((e) => {
        e.preventDefault();
        setErrorMessage('');
        storeAnimal('dog', $('#dog-name').val().trim());
    });

    $('#clear-lists').click(() => {
        setErrorMessage('');
        deleteAnimals();
    });

    getAnimals();
});

const getAnimals = () =>
    $.ajax({
        type: 'GET',
        url: '/api/v1/index',
    })
        .done((data) => {
            animals = JSON.parse(data).animals;
            sortAnimals(animals);
        })
        .fail((error) => {
            setErrorMessage(JSON.parse(error.responseText).error);
        });

const storeAnimal = (species, name) =>
    $.ajax({
        type: 'PUT',
        url: '/api/v1/store/' + species,
        data: `name=${name}`
    })
        .done((data) => {
            const animal = JSON.parse(data).animal;
            animals.push(animal);
            sortAnimal(animal);
            setFormColor();
            $(`#${species}-name`).val('');
        })
        .fail((error) => {
            setErrorMessage(JSON.parse(error.responseText).error);
        });

const deleteAnimals = () =>
    $.ajax({
        type: 'DELETE',
        url: '/api/v1/delete',
    })
        .done(() => {
            clearAll();
        })
        .fail((error) => {
            setErrorMessage(JSON.parse(error.responseText).error);
        });

const sortAnimals = (animals) => {
    $.each(animals, (_, animal) => {
        sortAnimal(animal);
    });
    setFormColor();
};

const sortAnimal = (animal) => {
    if (animal.species === 'cat') {
        catCount++;
        $('#cat-list').prepend('<li class="animal">' + animal.name + '</li>');
    } else if (animal.species === 'dog') {
        dogCount++;
        $('#dog-list').prepend('<li class="animal">' + animal.name + '</li>');
    }
};

const setFormColor = () => {
    if (catCount > dogCount) {
        $('#cat-form').css('background-color', '#2eaf5f');
    } else if (catCount < dogCount) {
        $('#dog-form').css('background-color', '#2eaf5f');
    } else {
        $('#cat-form').css('background-color', 'unset');
        $('#dog-form').css('background-color', 'unset');
    }
};

const setErrorMessage = (error) => {
    if (error) {
        $('#error-message')
            .addClass('error-visible')
            .text(error);
    } else {
        $('#error-message')
            .removeClass('error-visible')
            .text('');
    }
};

const clearAll = () => {
    animals = [];
    catCount = 0;
    dogCount = 0;
    $('#cat-list').empty();
    $('#dog-list').empty();
    setFormColor();
};