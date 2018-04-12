<?php
/**
 * Created by PhpStorm.
 * User: Serhii
 * Date: 10.04.2018
 * Time: 22:54
 */

declare(strict_types = 1);
header("Content-type:text/html;charset=utf-8");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="vendor/twitter/bootstrap/dist/css/bootstrap.min.css">
    <script src="vendor/twitter/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="jquery-3.2.1.js"></script>


    <script>
        $(function () {
            $('#items').on('keyup', checkParam);
            $('#algorithmType').on('change', checkParam);

            $('#fillContainers').on('click', function () {
                //Очищаем содержимое таблицы
                $('#resTable').empty();
                $('#countComparison').empty();
                $('#countContainers').empty();
                $('#minCountContainers').empty();

                $.ajax({
                    url: 'main/fillContainers.php',
                    type: 'post',
                    data: $('form').serialize(),
                    success: function (data) {
                        data = JSON.parse(data);
                        var countContainers = data['countContainers'];
                        var countComparisons = data['countComparisons'];
                        var listContainers = data['listContainers'];
                        var minCountContainers = data['minCountContainers'];
                        $('#countContainers').append("Количество контейнеров: " + countContainers);
                        $('#countContainers').addClass('alert alert-primary');

                        $('#countComparison').append("Количество операций стравнения: " + countComparisons);
                        $('#countComparison').addClass('alert alert-primary');

                        $('#minCountContainers').append("Min необходимое кол-во контейнеров: " + minCountContainers);
                        $('#minCountContainers').addClass('alert alert-primary');

                        //Найдем max кол-во грузов в контейнере для задания colspan табл
                        var max = 0;
                        for (var i = 0; i < listContainers.length; i++) {
                            if (listContainers[i].length > max) {
                                max = listContainers[i].length;
                            }
                        }

                        var table = '';
                        table += '<thead><tr>' +
                            '<th>Номер контейнера</th>' +
                            `<th style="text-align: center" colspan="${max}">Грузы</th>` +
                            '</tr></thead><tbody>';
                        var numContainer = 1;
                        for (var i = 0; i < listContainers.length; i++) {
                            table += '<tr>' + '<td>' + numContainer++ + '</td>';
                            for (var j = 0; j < listContainers[i].length; j++) {
                                table += '<td>' + listContainers[i][j] + '</td>';
                            }
                            table += '</tr>';
                        }
                        table += '</tbody>';
                        $('#resTable').append(table);
                    }
                });
            });
        });

        //Проверка на ввод параметров
        function checkParam() {
            var items = $('#items').val();
            if (($('#algorithmType :selected').val() != 'choose') && items.length != 0) {
                $('#fillContainers').removeAttr('disabled');
            } else {
                $('#fillContainers').attr('disabled', 'disabled');
            }
        }
    </script>

</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <form style="margin: 50px;">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="items">Веса грузов:</label>
                            <input type="text" class="form-control" name='items' id="items"
                                   placeholder="Введите веса грузов">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="unsorted" value="unsorted"
                                   checked>
                            <label class="form-check-label" for="unsorted">
                                Заполнение без упорядочивания
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="sorted" value="sorted">
                            <label class="form-check-label" for="sorted">
                                Заполнение с упорядочиванием
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="algorithmType"> Алгоритм заполнения</label>
                            <select class="form-control" id="algorithmType" name="algorithmType">
                                <option value="choose">Выберите алгоритм...</option>
                                <option value="NFA">NFA</option>
                                <option value="FFA">FFA</option>
                                <option value="WFA">WFA</option>
                                <option value="BFA">BFA</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <button type="button" id="fillContainers" class="btn btn-primary" disabled>
                                Заполнить контейнеры
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <div class="row" style="margin: 50px;">
        <div class="col-sm-6">
            <table class="table table-bordered table-hover" id="resTable"></table>
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-6">
                    <div role="alert" id="countContainers"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div role="alert" id="countComparison"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div role="alert" id="minCountContainers"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
