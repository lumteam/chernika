<div id="fast-view-modal" class="mfp-hide fast-view-container">
    <div class="modal-header">
        <button class="mfp-close">
            <svg class="modal-close-icon"><use xlink:href="#close"/></svg>
        </button>
    </div>
    <div class="fast-view js-prod_card"></div>
</div>
<div id="prod-order" class="mfp-hide city-container">
    <div class="modal-header">
        <div class="h4">Оформление заказа</div>
        <button class="mfp-close">
            <svg class="modal-close-icon"><use xlink:href="#close"/></svg>
        </button>
    </div>
    <form class="feedbacks-modal-body" id="form-prod-order">
        <div class="form-items">
            <div class="text-center">
                <p>Оплата&nbsp;&mdash; после примерки. Доставим курьером или самовывоз из&nbsp;салона.</p>
            </div>
            <div class="form-item">
                <input type="text" placeholder="Введите имя: (Не обязательно)" class="input" name="name">
            </div>
            <div class="form-item">
                <input type="text" placeholder="Введите номер телефона:" class="input phonemask" name="phone" required>
            </div>
            <div class="form-item">
                <input type="text" placeholder="Введите промокод: (Не обязательно)" class="input" name="promocode">
            </div>
            <div class="form-item">
                <textarea name="text" placeholder="Комментарий: (Не обязательно)" class="textarea"></textarea>
            </div>
            <div class="form-item">
                <button type="submit" class="submit-btn">Оформить заказ</button>
            </div>
            <div class="form-item">
                <label class="checkbox">Согласен на обработку <a href="/privacy-policy/" target="_blank">персональных данных</a>, а также с условиями оферты.
                    <input type="checkbox" checked="checked" name="agree">
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
        <input type="hidden" name="id" value="">
        <input type="hidden" name="type" value="">
        <input type="hidden" name="action" value="prood_order">
        <input type="hidden" name="referer" value="">
        <input type="hidden" name="freferer" value="">
        <input type="hidden" name="clientID" value="">
    </form>
</div>
<div id="prod-preorder" class="mfp-hide city-container">
    <div class="modal-header">
        <div class="h4">Оформить предзаказ</div>
        <button class="mfp-close">
            <svg class="modal-close-icon"><use xlink:href="#close"/></svg>
        </button>
    </div>
    <form class="feedbacks-modal-body" id="form-prod-preorder" onsubmit="ym(24545261, 'reachGoal', 'rezerv'); return true;">
        <div class="text-center">
            <p>Конечную стоимость товара и&nbsp;срок поставки уточнит менеджер при подтверждении заказа. Цена может быть незначительно скорректирована с&nbsp;учётом курсовой разницы.</p>
        </div>
        <div class="form-items">
            <div class="form-item">
                <input type="text" placeholder="Введите имя:" class="input" name="name">
            </div>
            <div class="form-item">
                <input type="text" placeholder="Введите номер телефона:" class="input phonemask" name="phone" required>
            </div>
            <?/*?><div class="form-item">
                <input type="email" placeholder="Введите ваш e-mail:" class="input" name="email">
            </div>
            <div class="form-item">
                <textarea name="text" cols="20" rows="10" placeholder="Комментарий:" class="textarea"></textarea>
            </div><?*/?>
            <div class="form-item">
                <button type="submit" class="submit-btn">Оформить</button>
            </div>
            <div class="form-item">
                <label class="checkbox">Согласен на обработку <a href="#">персональных данных</a>, а также с условиями оферты.
                    <input type="checkbox" checked="checked" name="agree">
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
        <input type="hidden" name="id" value="">
        <input type="hidden" name="type" value="">
        <input type="hidden" name="referer" value="">
        <input type="hidden" name="freferer" value="">
        <input type="hidden" name="clientID" value="">
        <input type="hidden" name="action" value="prood_preorder">
    </form>
</div>
<div id="prod-order_spb" class="mfp-hide city-container">
    <div class="modal-header">
        <div class="h4">Оформление заказа</div>
        <button class="mfp-close">
            <svg class="modal-close-icon"><use xlink:href="#close"/></svg>
        </button>
    </div>
    <form class="feedbacks-modal-body" id="form-prod-order_spb">
        <div class="form-items">
            <div class="text-center" style="margin-bottom: 20px;">
                <p>Оплата&nbsp;&mdash; после примерки. Доставим курьером или самовывоз из&nbsp;салона.</p>
            </div>
            <div class="form-item">
                <input type="text" placeholder="Введите имя: (Не обязательно)" class="input" name="name">
            </div>
            <div class="form-item">
                <input type="text" placeholder="Введите номер телефона:" class="input phonemask" name="phone" required>
            </div>
            <div class="form-item">
                <input type="text" placeholder="Введите промокод: (Не обязательно)" class="input" name="promocode">
            </div>
            <div class="form-item">
                <textarea name="text" placeholder="Комментарий: (Не обязательно)" class="textarea"></textarea>
            </div>
            <div class="form-item">
                <button type="submit" class="submit-btn">Оформить заказ</button>
            </div>
            <div class="form-item">
                <label class="checkbox">Согласен на обработку <a href="/privacy-policy/" target="_blank">персональных данных</a>, а также с условиями оферты.
                    <input type="checkbox" checked="checked" name="agree">
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
        <input type="hidden" name="id" value="">
        <input type="hidden" name="type" value="">
        <input type="hidden" name="action" value="prood_order_spb">
        <input type="hidden" name="referer" value="">
        <input type="hidden" name="freferer" value="">
        <input type="hidden" name="clientID" value="">
    </form>
</div>
<div id="prod-orderprice" class="mfp-hide city-container">
    <div class="modal-header">
        <div class="h4">Уточнить стоимость</div>
        <button class="mfp-close">
            <svg class="modal-close-icon"><use xlink:href="#close"/></svg>
        </button>
    </div>
    <form class="feedbacks-modal-body" id="form-prod-orderprice">
        <div class="text-center">
<?/*
            <p>В&nbsp;ближайшее время с&nbsp;вами свяжется менеджер интернет-магазина.</p>
*/?>
        </div>
        <div class="form-items">
            <div class="form-item">
                <input type="text" placeholder="Введите имя:" class="input" name="name">
            </div>
            <div class="form-item">
                <input type="text" placeholder="Введите номер телефона:" class="input phonemask" name="phone" required>
            </div>
            <?/*?><div class="form-item">
                <input type="email" placeholder="Введите ваш e-mail:" class="input" name="email">
            </div>
            <div class="form-item">
                <textarea name="text" cols="20" rows="10" placeholder="Комментарий:" class="textarea"></textarea>
            </div><?*/?>
            <div class="form-item">
                <button type="submit" class="submit-btn">Узнать</button>
            </div>
            <div class="form-item">
                <label class="checkbox">Согласен на обработку <a href="#">персональных данных</a>, а также с условиями оферты.
                    <input type="checkbox" checked="checked" name="agree">
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
        <input type="hidden" name="id" value="">
        <input type="hidden" name="type" value="">
        <input type="hidden" name="referer" value="">
        <input type="hidden" name="freferer" value="">
        <input type="hidden" name="clientID" value="">
        <input type="hidden" name="action" value="prod_orderprice">
    </form>
</div>
<div id="to-cart-modal" class="mfp-hide city-container add-to-cart__container">
    <div class="modal-header">
        <div class="h4">Товар добавлен в корзину</div>
        <button class="mfp-close">
            <svg class="modal-close-icon"><use xlink:href="#close"/></svg>
        </button>
    </div>
    <div class="modal__content">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="add-to-cart__img"><img src="" alt="" class="img-responsive js-img"></div>
            </div>
            <div class="col-12 col-md-6">
                <p class="add-to-cart-item-info-title marginless js-name"></p>
                <p class="add-to-cart-item-info-size light-color marginless">Артикул: <span class="js-article"></span></p>
                <p class="add-to-cart-item-info-size light-color marginless">Размер: <span class="js-size"></span></p>
                <p class="add-to-cart-item-info-color light-color marginless">Цвет: <span class="js-color"></span></p><br>
                <div class="h3 cart-item-price-value js-price"></div>
                <?/*<a href="#" class="submit-btn tac js-podbor">Подобрать линзы</a>*/?><a href="/personal/cart/" class="submit-btn tac addcartbtn">Перейти в корзину</a>
            </div>
        </div>
    </div>
</div>
