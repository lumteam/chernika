<?
namespace PDV\Handlers;

use \Bitrix\Main\Loader,
    \Bitrix\Main\Entity;

class Highload {
    public static function onBeforeAdd( Entity\Event $event ) {
        $data = $event->getParameter("fields");

        $result = new Entity\EventResult();

        $modifyFields = array();
        if ( empty($data['UF_XML_ID']) )
            $modifyFields['UF_XML_ID'] = \CUtil::translit($data['UF_NAME'], 'ru');

        if ( !empty($modifyFields) )
            $result->modifyFields($modifyFields);

        return $result;
    }

    public static function createPodmenaFile( Entity\Event $event ) {
        $arHLBlock = \Bitrix\Highloadblock\HighloadBlockTable::getById( HIGHBLOCK_ID__PODMENA_URL )->fetch();
        $obEntity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity( $arHLBlock );
        $strEntityDataClass = $obEntity->getDataClass();

        $arr = [];
        $rsData = $strEntityDataClass::getList(array(
            'select' => array('*'),
            'order' => array('ID' => 'ASC')
        ));
        while ( $arItem = $rsData->Fetch() ) {
            $arr[ $arItem['UF_LINK'] ] = $arItem['UF_NAME'];
        }

        $text = '<?return array(';
        $n = 1;
        foreach ( $arr as $i => $langArr ) {
            $text .= '\''.$i.'\' => \''. $langArr .'\'';
            if ( $n < count($arr) ) $text .= ',';
            $n++;
        }
        $text .= ');?>';

        if ( $handle = fopen($_SERVER['DOCUMENT_ROOT'].'/upload/psevdo_page.php', 'w') ) {
            fwrite($handle, $text);
            fclose($handle);
        }
    }
}