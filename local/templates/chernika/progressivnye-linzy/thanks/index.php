<?require(
$_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Спасибо");
?>



<div class="banner" style="background-image: url('../4banner.jpg');">
		<div class="row">
			<div class="col-md-7">
				<h1>Спасибо!</h1>
				<p>Наш менеджер свяжется с Вами в ближайшее время!</p>
				<a href="/linzy/progressivnye-linzy-dlya-ochkov/" class="btn">Назад</a>
			</div>
		</div>
</div>











<style>
	.footer {margin-top: 0 !important;}

	.page-title {display: none;}
	h2 {margin-top: 60px;}
	.breadcrumbs.d-xl-block {display: none !important;}
	.banner {background-position: center right; background-size: auto 100%; background-repeat: no-repeat;}
	.banner h1 {line-height: normal;}
	.banner .col-md-7 {padding-top: 30px; padding-bottom: 30px;}
	.btn {background-color: #691be7; padding: 10px 30px; display: inline-flex; color: #fff; border-radius: 30px; font-size: 18px; margin-top: 10px; outline: none; border: 0; cursor: pointer;}
	.btn:hover {background-color: #7c37ea;}
	.textBlock h3 {margin-top: 50px; margin-bottom: 0;}
	.textBlock h3+p {margin-top: 15px;}
	.textBlock h2 span {display: block; font-size: 18px; font-weight: normal;}
	.textBlock p span {color: #691be7; font-weight: bold;}
	.imageLeft {margin-top: 20px;}
	.imageLeft img {width: 100%;}
	.imageLeft p {line-height: normal;}
	.imageLeft p:first-child {margin-top: 0;}
	.checkNum {margin-top: 15px;}
	.checkItem {display: flex; flex-direction: row; align-items: center;}
	.checkItem img {height: 45px; margin-right: 5px;}
	.checkItem .num {width: 40px; height: 40px; display: flex; justify-content: center; align-items: center; border-radius: 50%; background-color: #691be7; color: #fff; margin-right: 15px; line-height: 18px; flex: none;}
	.checkItemNum p {margin: 0; line-height: normal;}
	.checkItemNum {align-items: flex-start;}
	.video {margin-top: 90px;}
	.video iframe {width: 100%; height: 400px;}

	.serii .col-md-6 {margin: 15px 0;}
	.seriiItem {border: 1px solid #000; padding: 0 40px 25px; height: 100%; display: flex; flex-direction: column;}
	.seriiItemTitle {font-weight: bold; margin-bottom: 0;}
	.seriiItemText {line-height: normal; flex-grow: 1;}
	.seriiItemFooter {display: flex; flex-direction: row; justify-content: space-between; align-items: center;}
	.seriiItemFooterPrice {font-size: 24px; margin: 0;}
	.seriiItemFooter .btn {margin-top: 0;}

	.skidka {background: #bbb;margin-top: 40px; padding: 30px 40px 60px 30px;}
	.skidka h3 {margin-top: 0;}
	.skidka p {line-height: normal; padding: 10px 0 20px;}
	.skidka p span {color: #691be7; text-decoration: underline; font-weight: bold;}
	
	.slider {margin-top: 30px;}
	.slider .viewed-slider p {margin-top: 5px;}

	.form {border: 1px solid #000; padding: 30px 40px 60px 30px; margin-top: 30px;}
	.form .col-md-8 {padding-left: 0;padding-right: 0;}
	.form h2 {margin-top: 0; margin-bottom: 0;}
	.form h2+p {margin-top: 5px;}
	.form .addPromo {text-decoration: underline;}
	#popup-consult .mfp-close {margin: 15px 0 15px auto;}

	.promoForm .form-item .c-input {border: 1px solid #b5b5b5;}

	.formButton {margin-top: 30px;}
	.formButton .col-md-6 {display: flex; align-items: center;}
	.formButton .btn { display: block; width: 100%; padding: 15px 30px; margin-top: 0;}
	.formButton p {margin: 0; line-height: normal;}

	.choseFile {}
	.choseFile label {display: flex; line-height: normal; align-items: center; cursor: pointer;}
	.choseFile label span {display: inline-flex; align-items: center; justify-content: center; width: 30px;height: 30px;border: 2px solid black; font-size: 28px; margin-right: 10px;}
	.choseFile .file-chosen span {display: inline-block; cursor: pointer; color: red; margin-left: 10px; font-size:16px;}

	body.magnificpopupnoscroll{
	   overflow-y: hidden !important;
	}

	.lastnameinp {position: absolute;left: -9999px;display: none;}

@media screen and (max-width:991px) {
	.banner {background-position: bottom right;}
	.seriiItemFooter {flex-direction: column;}
	.form .col-md-8 {width: 100%; max-width: 100%;}
}
@media screen and (max-width:767px) {
	.banner {background: none;}
	.seriiItemFooter {align-items: flex-end;}
	.form {padding: 30px; margin-bottom: 60px;}
	.choseFile {margin-top: 30px;}
	.formButton p {margin-top: 15px; text-align: center; width: 100%;}
}
</style>

<style>
	.marquiz__container_inline {
        margin: 10px 0 0 0;
    }

	@media screen and (max-width: 767px){
	    jdiv.__jivoMobileButton {
	        margin-bottom: 50px;
	        margin-left: -15px;}
	}

	@media (max-height: 700px) and (min-width: 1023px) {
	    #marquiz__close {
	        top: -15px !important;
	    }
	}

	@media (max-height: 653px) and (min-width: 1023px) {
	    #marquiz__close {
	        top: -10px !important;
	    }
	    .marquiz__bg_open .marquiz__modal {
	        height: 100% !important;
	    }
	}
</style>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

