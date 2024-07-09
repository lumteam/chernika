<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter24545261 = new Ya.Metrika2({
                    id:24545261,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "/local/templates/chernika/js/seo/tag.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks2");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/24545261" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
    (function(){ var widget_id = 'bLIaetlekU';var d=document;var w=window;function l(){var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
</script>
<!-- {/literal} END JIVOSITE CODE -->
<!-- --------k50---------- -->
<?php
$cityLabel = 'other';

if($CITY_NAME == 'Санкт-Петербург'){ $cityLabel = 'spb';}
if($CITY_NAME == 'Москва'){ $cityLabel = 'msk';}
?>
<?/*?><script>
    (function(c,a,p) {
        var s = document.createElement(a); s.src = p; s.type = "text/javascript"; s.async =!0; s.readyState ? s.onreadystatechange = function() { if ( s.readyState === "loaded" || s.readyState === "complete" ) { s.onreadystatechange = null; c();}} : s.onload = function () {c();}; var n = document.getElementsByTagName(a)[0]; n.parentNode.insertBefore(s,n); })(function(){
        k50Tracker.init({
            siteId: 21128985799537,
            landing: '<?php echo $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];?>',
            label: '<?php echo $cityLabel;?>'
        })
    },"script","https://k50-a.akamaihd.net/k50/k50tracker2.js");
</script><? */?>

<!-- --------------------- -->

<script>
    $(document).ready(function(){

        var utmsource= "<?=$_SESSION['utm_source']?>";

        function p(a,b,element){
            if(!element)element=document.body;
            var nodes=$(element).contents().each(function(){
                if(this.nodeType==Node.TEXT_NODE){
                    var r=new RegExp(a,'gi');
                    this.textContent=this.textContent.replace(r,b);
                } else {
                    p(a,b,this);
                }
            });
        }

        if(utmsource.length > 0){
            p('302-32-89','551-63-66');

            $('a[href="tel:+78003023289"]').each(function(){
                this.href = 'tel:+78005516366';
            });
        }
    });
</script>
