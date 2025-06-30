<?
$aMenuLinks = Array(
	Array(
		"Продукция", 
		"products/", 
		Array(), 
		Array('PRODUCTS'=> 'Y'),
		"" 
	),
	Array(
		"О компании", 
		"about/", 
		Array(), 
		Array(
            'sevice'=> array('TEXT'=>'Сервис', 'LINK'=>'/sevice/'),
            'portfolio'=> array('TEXT'=>'Портфолио', 'LINK'=>'/portfolio/'),
            'media'=> array('TEXT'=>'Медиа', 'LINK'=>'/media/'),
            'news'=> array('TEXT'=>'Новости', 'LINK'=>'/news/'),
            'recommendations'=> array('TEXT'=>'Советы', 'LINK'=>'/recommendations/'),
        ),
		"" 
	),
	Array(
		"Сотрудничество", 
		"сooperation/", 
		Array(),
        Array(
            'sevice'=> array('TEXT'=>'Архитекторам', 'LINK'=>'/architect/'),
            'portfolio'=> array('TEXT'=>'Дилерам', 'LINK'=>'/for-dealers/'),
        ),
		"" 
	),

	Array(
		"Акции", 
		"share/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Контакты", 
		"contacts/", 
		Array(), 
		Array(), 
		"" 
	)
);
?>