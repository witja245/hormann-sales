<? require( $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php' );

$str = '/upload/medialibrary/493/45ar1q7h4sze3hiqi1tlnd6qwlewqzsd.jpg,/upload/medialibrary/d80/9edchh847effxsg7r8maubrms7igzhkq.jpg,/upload/medialibrary/6f4/w3tiu2xhh1q3hzozey2qohjm0hubmr9g.jpg,/upload/medialibrary/6f4/w3tiu2xhh1q3hzozey2qohjm0hubmr9g.jpg,/upload/medialibrary/a51/5lvb2qbhnd2twk4wrtv8aclbyyqj26d8.jpg,/upload/medialibrary/9c9/n3fyym6zhili6d7srki6mh44omy8mkcf.jpg';

var_dump(count(explode(',',$str)));