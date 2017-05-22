@extends('layouts.app')

@section('content')
    <div class="container detail wrap-checkout filter__shop">
        <div class="text-center mgB-50">
            <ul class="breakcum">
                <li><a href="">HOME</a></li>
                <li><span>/</span></li>
                <li class="active">STAFF AREA</li>
            </ul>
        </div>
        <div class="checkout__inner clearfix">
            <div class="checkout__infor">
                <div class="filter__product">
                    <div class="frm-item">
                        <div class="frm-item-icon">
                            <input type="text" placeholder="Name , SKU , Color ...">
                            <button><span class="icon-slice9"></span></button>
                        </div>
                    </div>

                    <div class="filter__item">
                        <table>
                            <tr>
                                <td>
                                    <div class="dropdown">
                                        <a href="" class="val-selected">
                                            Brand
                                            <div class="get-val"></div>
                                            <span class="icon-uniF140"></span>
                                        </a>
                                        <div class="dropdown-up-style hide">
                                            <div class="dropdown__inner">
                                                <ul>
                                                    <li><a href="" data-value="1">Adidas</a></li>
                                                    <li><a href="" data-value="2">Nike</a></li>
                                                    <li><a href="" data-value="3">Adidas</a></li>
                                                    <li><a href="" data-value="4">Adidas</a></li>
                                                    <li><a href="" data-value="5">Adidas</a></li>
                                                    <li><a href="" data-value="6">Adidas</a></li>
                                                    <li><a href="" data-value="7">Adidas</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <input type="hidden" value="" />
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a href="" class="val-selected">
                                            Size
                                            <div class="get-val"></div>
                                            <span class="icon-uniF140"></span>
                                        </a>
                                        <div class="dropdown-up-style hide">
                                            <div class="dropdown__inner">
                                                <ul>
                                                    <li><label for="" class="frm"><input type="radio" />Men US</label></li>
                                                    <li><label for="" class="frm"><input type="radio" />Women US</label></li>
                                                    <li><a href="" data-value="1">7</a></li>
                                                    <li><a href="" data-value="2">8</a></li>
                                                    <li><a href="" data-value="3">9</a></li>
                                                    <li><a href="" data-value="4">1</a></li>
                                                    <li><a href="" data-value="5">3</a></li>
                                                    <li><a href="" data-value="6">4</a></li>
                                                    <li><a href="" data-value="7">5</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <input type="hidden" value="" />
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a href="" class="val-selected">
                                            Color
                                            <div class="get-val"></div>
                                            <span class="icon-uniF140"></span>
                                        </a>
                                        <div class="dropdown-up-style hide">
                                            <div class="dropdown__inner">
                                                <ul>
                                                    <li><a href="" data-value="1">red</a></li>
                                                    <li><a href="" data-value="2">black</a></li>
                                                    <li><a href="" data-value="3">bla bla</a></li>
                                                    <li><a href="" data-value="4">bla bla</a></li>
                                                    <li><a href="" data-value="5">bla bla</a></li>
                                                    <li><a href="" data-value="6">bla bla</a></li>
                                                    <li><a href="" data-value="7">bla bla</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="clearfix price__range">
                                        <div class="pull-left">
                                            <p class="font-600">From</p>
                                        </div>
                                        <div class="pull-right">
                                            <input type="text" value="0.0" class="filter__price" />đ
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="clearfix price__range">
                                        <div class="pull-left">
                                            <p class="font-600">To</p>
                                        </div>
                                        <div class="pull-right pdR-10">
                                            <input type="text" value="0.0" class="filter__price" />đ
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="filter__item--btn text-center">
                            <button class="btn-small">APPLY</button>
                            <button class="btn-reset">RESET</button>
                        </div>
                    </div>

                    <div class="filter__result">
                        <table>
                            <thead>
                            <tr>
                                <td class="id__result"><p>ID</p></td>
                                <td class="name__result"><p>Name</p></td>
                                <td class="size__result"><p><a href="">Size<span class="icon-uniF140"></span></a></p></td>
                                <td class="qty__result"><p>Qty</p></td>
                                <td class="condition__result"><p><a href="">Condition<span class="icon-uniF140"></span></a></p></td>
                                <td class="price__result"><p><a href="">Price<span class="icon-uniF140"></span></a></p></td>
                                <td class="addcart__result"><p>Add cart</p></td>
                            </tr>
                            </thead>
                            <tr>
                                <td><p>1</p></td>
                                <td><p class="text-uper">Air Jordan 1 bred 2016</p></td>
                                <td><p>9</p></td>
                                <td><p>1</p></td>
                                <td><p class="text-uper">new</p></td>
                                <td><p>6.800.000</p></td>
                                <td>
                                    <div class="up__down--qty">
                                        <span class="qty__down"><span class="icon-circle-minus"></span></span>
                                        <span class="qty__val">1</span>
                                        <span class="qty__up"><span class="icon-circle-plus"></span></span>
                                        <input type="hidden" value="5">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><p>1</p></td>
                                <td><p class="text-uper">Air Jordan 1 bred 2016</p></td>
                                <td><p>9</p></td>
                                <td><p>1</p></td>
                                <td><p class="text-uper">new</p></td>
                                <td><p>6.800.000</p></td>
                                <td>
                                    <div class="up__down--qty">
                                        <span class="qty__down"><span class="icon-circle-minus"></span></span>
                                        <span class="qty__val">1</span>
                                        <span class="qty__up"><span class="icon-circle-plus"></span></span>
                                        <input type="hidden" value="1">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><p>1</p></td>
                                <td><p class="text-uper">Air Jordan 1 bred 2016</p></td>
                                <td><p>9</p></td>
                                <td><p>1</p></td>
                                <td><p class="text-uper">new</p></td>
                                <td><p>6.800.000</p></td>
                                <td>
                                    <div class="up__down--qty">
                                        <span class="qty__down"><span class="icon-circle-minus"></span></span>
                                        <span class="qty__val">1</span>
                                        <span class="qty__up"><span class="icon-circle-plus"></span></span>
                                        <input type="hidden" value="1">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><p>1</p></td>
                                <td><p class="text-uper">Air Jordan 1 bred 2016</p></td>
                                <td><p>9</p></td>
                                <td><p>1</p></td>
                                <td><p class="text-uper">new</p></td>
                                <td><p>6.800.000</p></td>
                                <td>
                                    <div class="up__down--qty">
                                        <span class="qty__down"><span class="icon-circle-minus"></span></span>
                                        <span class="qty__val">1</span>
                                        <span class="qty__up"><span class="icon-circle-plus"></span></span>
                                        <input type="hidden" value="1">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><p>1</p></td>
                                <td><p class="text-uper">Air Jordan 1 bred 2016</p></td>
                                <td><p>9</p></td>
                                <td><p>1</p></td>
                                <td><p class="text-uper">new</p></td>
                                <td><p>6.800.000</p></td>
                                <td>
                                    <div class="up__down--qty">
                                        <span class="qty__down"><span class="icon-circle-minus"></span></span>
                                        <span class="qty__val">1</span>
                                        <span class="qty__up"><span class="icon-circle-plus"></span></span>
                                        <input type="hidden" value="1">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><p>1</p></td>
                                <td><p class="text-uper">Air Jordan 1 bred 2016</p></td>
                                <td><p>9</p></td>
                                <td><p>1</p></td>
                                <td><p class="text-uper">new</p></td>
                                <td><p>6.800.000</p></td>
                                <td>
                                    <div class="up__down--qty">
                                        <span class="qty__down"><span class="icon-circle-minus"></span></span>
                                        <span class="qty__val">1</span>
                                        <span class="qty__up"><span class="icon-circle-plus"></span></span>
                                        <input type="hidden" value="1">
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="clearfix">
                            <div class="pagi__filter">
                                <a href=""><span class="icon-navigate_before"></span></a>
                                <input type="text" value="1" />
                                <a href=""><span class="icon-navigate_next"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush