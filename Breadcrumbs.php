<?php
/**
 * Виджет для вывода хлебных крошек
 */
namespace alien\Breadcrumbs;

use Yii;
use yii\helpers\Html;

class Breadcrumbs extends yii\base\Widget
{

    // See Breadcrumbs.php for more details
	public $tagName='ul';
	public $htmlOptions=array('class'=>'breadcrumbs');
	public $encodeLabel=true;
	public $homeLink;
	public $links=array();
	public $separator=' &raquo; ';

	public function run()
	{
		$view = $this->getView();
                BreadcrumbsAsset::register($view);
                if (empty($this->links))
			return;

                echo Html::beginTag('div', ['id'=>'breadcrumbs', 'class'=>'breadCrumb']);
		echo Html::beginTag($this->tagName,$this->htmlOptions)."\n";

		if(isset($this->homeLink))
            echo '<li>'.Html::a(Html::tag('i', '', ['class' => 'home fa fa-home']),$this->homeLink).'</li>';
                
		foreach($this->links as $item)
                {    
                        if (is_array($item))
                        {
                            if(is_string($item['label']) || is_array($item['url']))
                                    $link=Html::a($this->encodeLabel ? Html::encode($item['label']) : $item['label'], $item['url']);
                            else
                                    $link='<span>'.($this->encodeLabel ? Html::encode($item['url']) : $item['url']).'</span>';
                        }
                        else
                            $link='<span>'.($this->encodeLabel ? Html::encode($item) : $item).'</span>';
                        
                        
                        if (is_array($item))
				echo '<li>'.$link.'</li>';
			else
				echo '<li class="noChevron">'.$link.'</li>';
			
		}
		echo Html::endTag($this->tagName);
                echo Html::endTag('div');
	}
        
        /**
	 * Инициализация
	 */
	public function init()
	{
            parent::init();
            $this->registerTranslations();
	}
     
        public function registerTranslations()
        {
            Yii::$app->i18n->translations['breadcrumbs'] = 
            [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@alien/Breadcrumbs/messages',
                'forceTranslation' => true
            ];
        }

}