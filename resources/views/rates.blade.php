@include('header')
<div class="container">
    <div class="row mt-5">

        @include('sidebar')
        <div class="col-lg-8 mt-2">


                        <div class="panel">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col col-sm-3 col-xs-12">
                                        <h4 class="title">Список Тарифов</h4>
                                    </div>

                                </div>
                            </div>
                            <div class="panel-body table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Название тарифов</th>
                                        <th>Единица измерение</th>
                                        <th>Цена за единицу(тенге)</th>
                                        <th>Расчетный период</th>
                                        <th>Действие</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Подписание документа (с приложениями)</td>
                                        <td>одна электронная цифровая подпись (ЭЦП)</td>
                                        <td>100</td>
                                        <td>Единовременно</td>
                                        <td>
                                           <button class="btn btn-danger">Купить</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Проверка договора (предоставление комментариев)</td>
                                        <td>один договор с приложениями</td>
                                        <td>2000</td>
                                        <td>Единовременно</td>
                                        <td>
                                            <button class="btn btn-danger">Купить</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Разработка договора</td>
                                        <td>один договор с приложениями</td>
                                        <td>10 000</td>
                                        <td>Единовременно</td>
                                        <td>
                                            <button class="btn btn-danger">Купить</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Подписание документа (с приложениями) до 100 в месяц</td>
                                        <td>одна электронная цифровая подпись (ЭЦП)</td>
                                        <td>9000</td>
                                        <td>Ежемесячно</td>
                                        <td>
                                            <button class="btn btn-danger">Купить</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Подписание документа (с приложениями) до 100 в месяц</td>
                                        <td>две электронные цифровые подписи (ЭЦП)</td>
                                        <td>12000</td>
                                        <td>Ежемесячно</td>
                                        <td>
                                            <button class="btn btn-danger">Купить</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Подписание документа (с приложениями) до 500 в месяц</td>
                                        <td>одна электронная цифровая подпись (ЭЦП)</td>
                                        <td>45000</td>
                                        <td>Ежемесячно</td>
                                        <td>
                                            <button class="btn btn-danger">Купить</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>Подписание документа (с приложениями) до 500 в месяц</td>
                                        <td>две электронные цифровые подписи (ЭЦП</td>
                                        <td>45000</td>
                                        <td>Ежемесячно</td>
                                        <td>
                                            <button class="btn btn-danger">Купить</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>




        </div>
    </div>
</div>


@include('footer')
