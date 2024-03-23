<?php
/**
 * Шаблон окна
 *
 * @see     https://wpruse.ru/my-plugins/art-woocommerce-order-one-click/
 * @package art-woocommerce-order-one-click/includes/view
 * @version 2.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;

$elements = get_option('woocommerce_awooc_select_item') ? get_option('woocommerce_awooc_select_item') : array();

?>

<div id="awooc-form-custom-order" class="awooc-form-custom-order awooc-popup-wrapper" style="display: none">
    <div class="awooc-close">&#215;</div>
    <div class="awooc-custom-order-wrap awooc-popup-inner">

        <div class="modal modal-bg   fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-w m-auto" role="document">
                <div class="modal-content border-0">
                    <div class="login-register-wrapper">
                        <div class=" ">
                            <button type="button" class="close p-4 " data-dismiss="modal" aria-label="Close" id="close_modal_btn">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div id="lg1" class="tab-pane active">
                                <div class="login-form-container px-5 pt-3">
                                    <h3 class="font-weight-bold text-center py-3">Купить товар в рассрочку</h3>
                                    <p class="text-center mb-4 product_modal_text"><?= $model->name; ?></p>
                                    <div class="login-register-form">
                                        <table class="table table-striped w-100">
                                            <thead>
                                            <tr class="p-2">
                                                <th scope="col">Оплата за месяц</th>
                                                <th scope="col">Срок (месяц)</th>
                                                <th scope="col">Общая сумма</th>
                                            </tr>
                                            </thead>
                                            <tbody class="text-white modal_text_bg" id="product_data">

                                            </tbody>
                                        </table>

                                        <form id="w1" action="/lead/kredit" method="post">
                                            <input type="hidden" name="_csrf-frontend"
                                                   value="y2vRCAwDTdjD1mop-b7pCqJaVm6OgPaNPLyhtMAREo64MeJ_fmB_ga2vU26a8Jk46A8BKd3Pgc5S7siFgiN66A==">
                                            <div class="form-group field-lead-phone required">
                                                <label class="control-label" for="lead-phone">Телефон</label>
                                                <input type="text" id="lead-phone" class="form-control" name="Lead[phone]" aria-required="true">

                                                <p class="help-block help-block-error"></p>
                                            </div>
                                            <span id="error-limit" style="display: none; color: red">Следующую покупку Вы можете совершить после 30 дней</span>
                                            <div class="button-box">
                                                <div class="login-toggle-btn">
                                                    <input id="check" type="checkbox">
                                                    <span> Я согласен с <a target="_blank" class="flote-none text-primary" href="/product/rule">  правилами  </a>  покупки товаров</span>
                                                </div>
                                                <button disabled="disabled" id="button_check" type="button" class="btn-primary disabled w-100 p-3 mt-2"><span>Проверить рассрочку</span>
                                                </button>
                                            </div>
                                        </form>


                                        <div style="margin-top:15px; display: none;" class="product-panel__btn" id="IntendResponse">
                                    <span class="shopping-cart-product__title">
                                        Вам необходимо зарегистрироваться в системе InTend с помощью мобильного приложения myid.uz<br>
                                        <a target="_blank" href="//myid.uz/ru/download/android">
                                            <img style="width:150px;" src="/assets-new/images/myid-android.png">
                                        </a>
                                        <a target="_blank" href="//myid.uz/ru/download/ios">
                                            <img style="width:150px;" src="/assets-new/images/myid-ios.png">
                                        </a>
                                        <hr>
                                        <a target="_blank" href="//myid.intend.uz/login">Регистрация в InTend</a>
                                        </div>

                                        <div style="margin-top:15px; display: none" class="product-panel__btn" id="IntendLimit">
                                            <span id="shopping-cart"></span>
                                            <br/>
                                            <button type="button" class="btn btn-success" id="AcceptInTendOrder" style="margin-top:10px">Оформить заказ</button>
                                        </div>

                                        <div style="margin-top:15px; display:none;" class="product-panel__btn" id="IntendSmsCode">
                                            <span class="shopping-cart-product__title">На указанный Вами номер телефона был отправлен СМС с кодом для подтверждения заказа. Подтвердите Ваш заказ указан код из СМС</span>
                                            <input style="float:left; margin-top: 10px" id="sms_input" name="intentduser-smscode" type="text" placeholder="Код из СМС">
                                            <span id="error-sms-code" style="display: block; color: red"></span>
                                            <button style="float: right;" type="button" id="AcceptCodeIntend" class="btn btn-success">Подтвердить заказ</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>

      $(document).ready(function () {
        $('#check').click(function () {
          if ($(this).is(':checked')) {
            $('#button_check').removeAttr('disabled')
            $('#button_check').removeClass('disabled')
          } else {
            $('#button_check').attr('disabled', 'disabled')
            $('#button_check').addClass('disabled', 'disabled')
          }
        })
      })

      $(document).ready(function () {
        $('#check2').click(function () {
          if ($(this).is(':checked')) {
            $('#button_check2').removeAttr('disabled')
            $('#button_check2').removeClass('disabled')
          } else {
            $('#button_check2').attr('disabled', 'disabled')
            $('#button_check2').addClass('disabled', 'disabled')
          }
        })
      })

      $(document).ready(function () {
        $('#button_check').click(function () {
          if ($(this).is(':checked')) {
            $('#button_check').removeAttr('disabled')
            $('#button_check').removeClass('disabled')
          } else {
            $('#button_check').attr('disabled', 'disabled')
            $('#button_check').addClass('disabled', 'disabled')
          }
        })
      })

      $('.awooc-custom-order-button').on('click', function () {
        $('#product_data').empty()
        $('#intend_click').attr('disabled', 'disabled')
        $('#intend_click').addClass('disabled_btn')
        $('#IntendSmsCode').css('display', 'none')
        $('#IntendLimit').css('display', 'none')
        $('#IntendResponse').css('display', 'none')
        $('#error-limit').css('display', 'none')
        $('.help-block help-block-error').css('display', 'none')
        product_id = $(this).data('pro_id')
        if (product_id) {
          $.ajax({
            url: '/intend/get-product-price',
            data: {
              product_id: product_id,
            },
            success: function (data) {
              if (data) {
                var rows = '<tr>'
                  + '<td>' + (data.per_month / 100).toLocaleString().replace(/,/gi, ' ') + '</td>'
                  + '<td>' + data.duration + '</td>'
                  + '<td>' + (data.price / 100).toLocaleString().replace(/,/gi, ' ') + '</td>'
                  + '</tr>'
                $('#product_data').append(rows)
                $('#productModal').modal('show')
              }

            },
          })
        }
      })

      $('#button_check').on('click', function () {
        phone = $('#lead-phone').val()
        phone_number = phone.replace('+', '')
        $('#IntendSmsCode').css('display', 'none')
        if (parseInt(phone_number).toString().length == 12) {
          $.ajax({
            type: 'POST',
            url: '/intend/phone-is-active',
            data: {
              'phone': phone_number,
            },
            dataType: 'json',
            success: function (data) {
              if (data.status == -1) {
                $('#IntendResponse').css('display', 'block')
              }
              if (data.status == 1) {
                if (data.limit == 1) {
                  $('#error-limit').css('display', 'block')
                } else {
                  $('#error-limit').css('display', 'none')
                  $('#shopping-cart').
                    text('Вам предоставляется необходимая для покупки лимит  - ' + (data.limit / 100).toLocaleString().replace(/,/gi, ' ') +
                      '  сум от системы InTend и Вы можете оформить заказ')
                  $('#IntendResponse').css('display', 'none')
                  $('#IntendLimit').css('display', 'block')
                }

              }
            },
          })
        } else {
          alert('Telfon raqamni to\'g\'ri kiritmadingiz')
        }

      })

      $('#AcceptInTendOrder').on('click', function () {
        product_id = $('#intend_click').data('pro_id')
        phone_number = $('#lead-phone').val()
        if (product_id) {
          $.ajax({
            type: 'POST',
            url: '/intend/create-lead',
            data: {
              product_id: product_id,
              phone_number: phone_number,
            },
            success: function (data) {
              console.log(data)
              if (data) {
                $('#IntendSmsCode').css('display', 'block')
                $('#IntendLimit').css('display', 'none')
              }
            },
          })
        }
      })

      $('#AcceptCodeIntend').on('click', function () {
        sms = $('#sms_input').val()
        if (sms) {
          $.ajax({
            type: 'POST',
            url: '/intend/sms-confirm',
            data: {
              sms: sms,
            },
            success: function (data) {
              if (data.status == true) {
                $('#error-sms-code').css('display', 'none')
                $('#productModal').modal('hide')
                alert('Xaridingiz uchun rahmat')
                $('#intend_click').removeAttr('disabled')
                $('#intend_click').removeClass('disabled_btn')
              } else {
                $('#error-sms-code').html(data.info)
              }
            },
          })
        }
      })

      // $("#close_modal_btn").on("click", function (){
      //     $('#intend_click').removeAttr('disabled');
      //     $('#intend_click').removeClass('disabled_btn');
      // });

      $('.modal').on('click', function () {
        $('#intend_click').removeAttr('disabled')
        $('#intend_click').removeClass('disabled_btn')
      })


    </script>
</div>

