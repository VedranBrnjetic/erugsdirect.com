use erugs;
go

drop view product_feed_simple_unique_view;
go 

create view product_feed_simple_unique_view 
as
select * from
(select 
	a.SKU as 'id', 
	a.Name + ' ' + LEFT(CAST(a.length as varchar(10)),LEN(CAST(a.length as varchar(10))) -5) + ' X ' + LEFT(CAST(a.width as varchar(10)),LEN(CAST(a.width as varchar(10))) -5) + ' cm' as 'title', 
	a.FullDescription as 'description', 
	598 as 'google_product_category', 
	'product type' as 'product_type', 
	'http://erugsdirect.com/' + b.slug as 'link',
	'http://erugsdirect.com/content/images/thumbs/' + RIGHT('0000000' + CAST(c.ID as varchar(7)) , 7) + '_' + c.SeoFilename + '.jpeg' as 'image_link',
	'new' as 'condition',
	'in stock' as 'availibility',
	a.oldprice as 'price',
	LEFT(CAST(a.length as varchar(10)),LEN(CAST(a.length as varchar(10))) -5) + ' X ' + LEFT(CAST(a.width as varchar(10)),LEN(CAST(a.width as varchar(10))) -5) + ' cm' as 'size',
	a.price as 'sale_price',
	'2015-11-01T00:01-0000/2015-12-31T23:59-0000' as 'sale_price_effective_date',
	(select 
		Name from productTag where id = (
			select top 1 ProductTag_Id from Product_ProductTag_Mapping 
				where Product_Id = a.ID and 
					productTag_ID in (97,14,2,87,4,11,53,77,84,68,79,101,73,54,12,10,3,19,74,85,43,99,103,90,66,83,72,76,93,89,5,56,25,7,94,8,6,55,52,86,8867,82,78,96,70,95,81,71,13,91,92,1,48,9,104,105)))
		as 'color',
	ROW_NUMBER() OVER (PARTITION BY a.SKU ORDER BY a.SKU desc) as RN
from
	product a 
		inner join urlRecord b on a.id = b.entityId and entityName = 'Product' and b.IsActive=1
		inner join (	SELECT ProductId,	min(PictureId) as pictureID      
					FROM Product_Picture_Mapping
					WHERE productID in (select id from product where VisibleIndividually=1 and Published=1 and ProductTypeId = 5 and ProductTemplateId = 1 and (len(SKU)<=8 or sku like 'euniq%'))
					GROUP BY ProductId) as ca on a.id = ca.ProductId
		left join Picture c on c.id = ca.pictureID

where
	a.VisibleIndividually=1 and a.Published=1 and a.ProductTypeId = 5 and a.ProductTemplateId = 1 and (len(a.SKU)<=8 or sku like 'euniq%') and a.StockQuantity>0) as x
where RN = 1


select * from product_feed_simple_unique_view