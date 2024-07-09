<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use Bitrix\Main\Context;

$request = Context::getCurrent()->getRequest();

$isAjaxRequest = ($request->isAjaxRequest() && $request->get('ajax'));
$isConfirmOrder = ($request->getPost('confirmorder') === 'Y');

if ($isAjaxRequest) {
    $APPLICATION->RestartBuffer();
}

global $USER;
if ($USER->IsAuthorized() || $arParams["ALLOW_AUTO_REGISTER"] == "Y") {
    if ($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y") {
        if (strlen($arResult["REDIRECT_URL"]) > 0) {
            $APPLICATION->RestartBuffer();
            ?>
            <script type="text/javascript">
                window.top.location.href = '<?=CUtil::JSEscape($arResult["REDIRECT_URL"])?>';
            </script>
            <?
            die();
        }
    }
}
?>

<a name="order_form"></a>

<div id="order_form_div" class="order-checkout content">
    <NOSCRIPT>
        <div class="errortext"><?= GetMessage("SOA_NO_JS") ?></div>
    </NOSCRIPT>

    <?
    if ($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y") {
        include($_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/confirm.php");
    } else {
        ?>
        <script type="text/javascript">
            var BXFormPosting = false;

            function submitForm(val) {
                if (BXFormPosting === true)
                    return true;

                BXFormPosting = true;
                if (val != 'Y')
                    BX('confirmorder').value = 'N';

                var orderForm = BX('ORDER_FORM');

                BX.showWait('ORDER_FORM');

                <?if(CSaleLocation::isLocationProEnabled()):?>
                BX.saleOrderAjax.cleanUp();
                <?endif?>

                BX.ajax.submit(orderForm, ajaxResult);

                return true;
            }

            function afterLoadData() {
                maskInput();
            }

            function ajaxResult(res) {
                var orderForm = BX('ORDER_FORM');
                try {
                    // if json came, it obviously a successfull order submit
                    var json = JSON.parse(res);
                    BX.closeWait();

                    if (json.error) {
                        BXFormPosting = false;
                        return;
                    } else if (json.redirect) {
                        window.top.location.href = json.redirect;
                    }
                } catch (e) {
                    // json parse failed, so it is a simple chunk of html

                    BXFormPosting = false;
                    BX('order_form_content').innerHTML = res;
                    <?if(CSaleLocation::isLocationProEnabled()):?>
                    BX.saleOrderAjax.initDeferredControl();
                    <?endif?>

                    afterLoadData();
                }

                BX.closeWait();
                BX.onCustomEvent(orderForm, 'onAjaxSuccess');
            }

            function SetContact(profileId) {
                BX("profile_change").value = "Y";
                submitForm();
            }
        </script>

        <?
        if ($_POST["is_ajax_post"] != "Y") {
        ?>
            <form action="<?= $APPLICATION->GetCurPage(); ?>" method="POST" name="ORDER_FORM" id="ORDER_FORM"
                  enctype="multipart/form-data" class="checkout novalid">
                <?= bitrix_sessid_post() ?>
                <div id="order_form_content" class="row">
        <?
        } else {
            $APPLICATION->RestartBuffer();
        }

                if ($_REQUEST['PERMANENT_MODE_STEPS'] == 1) {?>
                    <input type="hidden" name="PERMANENT_MODE_STEPS" value="1"/>
                <?}?>

                <?if (!empty($arResult["ERROR"]) && $arResult["USER_VALS"]["FINAL_STEP"] == "Y") {
                    /*foreach( $arResult["ERROR"] as $v ) {
                        echo '<div class="form-group error">'.$v.'</div>';
                    }*/
                    ?>
                    <script type="text/javascript">
                        top.BX.scrollToNode(top.BX('ORDER_FORM'));
                    </script>
                    <?
                }

                include($_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/person_type.php");
                include($_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/props.php");

                if (strlen($arResult["PREPAY_ADIT_FIELDS"]) > 0)
                    echo $arResult["PREPAY_ADIT_FIELDS"];
                ?>

        <?if ($_POST["is_ajax_post"] != "Y") {?>
                </div>

                <input id="confirmorder" type="hidden" value="Y" name="confirmorder">
                <input id="profile_change" type="hidden" value="N" name="profile_change">
                <input id="is_ajax_post" type="hidden" value="Y" name="is_ajax_post">
                <input type="hidden" value="Y" name="json">
				
            </form>
        <?} else {?>
            <script type="text/javascript">
                top.BX('confirmorder').value = 'Y';
                top.BX('profile_change').value = 'N';
            </script>
            <?
            die();
        }
    }
    ?>
</div>