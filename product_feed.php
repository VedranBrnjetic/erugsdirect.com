<?xml version='1.0'?>
<rss version ='2.0' xmlns:g='http://base.google.com/ns/1.0'>
<channel>
<title>ErugsDirect Limited</title>
<description>E Rugs Direct specialises in providing the best quality oriental handmade traditional rugs. We have a vast range of both traditional and modern rugs in a selection of different styles, colours, sizes and designs to suit your needs.</description>
<link>http://erugsdirect.com/</link>

<?php 



$SQL_CONNECTION_ERUGS = sqlsrv_connect('DSVR016177\SQLEXPRESS2014',array("Database"=>"ERugs","CharacterSet"=>"UTF-8"));

if( !$SQL_CONNECTION_ERUGS ) {
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}
ini_set('mssql.charset', 'utf-8');
$sql_ERUGS=" 
SELECT id,title,description,google_product_category,product_type,link,image_link,condition,availibility,price,size,sale_price,sale_price_effective_date,color
  FROM product_feed_simple_unique_view;
";

$stmt_ERUGS=sqlsrv_query ( $SQL_CONNECTION_ERUGS , $sql_ERUGS);
while( $item = sqlsrv_fetch_array( $stmt_ERUGS, SQLSRV_FETCH_ASSOC) ) {
	 ?>
<item>
    <g:id><?php echo $item['id']; ?></g:id>
    <g:identifier_exists>FALSE</g:identifier_exists>
	<title><![CDATA[<?php echo utf8_encode(htmlspecialchars_decode($item['title'] . " RUG")); ?>]]></title>
    <link><![CDATA[<?php echo $item['link']; ?>]]></link>
    <g:price><?php echo $item['sale_price']; ?> GBP</g:price>
    <description><![CDATA[<?php echo utf8_encode(htmlspecialchars_decode($item['description'])); ?>]]></description>
    <g:condition><?php echo $item['condition']; ?></g:condition>
    <g:image_link><![CDATA[<?php echo $item['image_link']; ?>]]></g:image_link>
    <g:product_type>Handmade rug</g:product_type>
    <g:google_product_category><?php echo $item['google_product_category']; ?></g:google_product_category>
    <g:availability><?php echo $item['availibility']; ?></g:availability>
	<g:delivery>
	   <g:country>GB</g:country>
	   <g:service>TNT</g:service>
	   <g:price>0.00 GBP</g:price>
	</g:delivery>
	<g:shipping>
	   <g:country>GB</g:country>
	   <g:service>TNT</g:service>
	   <g:price>0.00 GBP</g:price>
	</g:shipping>
	<g:size><![CDATA[<?php echo $item['size']; ?>]]></g:size>
    <g:color><![CDATA[<?php echo $item['color']; ?>]]></g:color>
</item>
<?php
}
?>

</channel>
</rss>  