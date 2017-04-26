SELECT name, address,image_url 
FROM restaurants 
WHERE( categories like '%Korea%' OR categories like '%Japanese%' ) 
AND ( price_level like '2' OR price_level like '3' )