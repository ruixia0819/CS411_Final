'''
0. find map from cities to latitude and longtitude  



1. find menu for one restaurant:
	a. get the restaurant name
	b.get the href for the restaurant
	c. for each category <most popular, beverage...>
		find name,
		find price

2. for all restaurants in Champaign

3. for all cities
'''

from BeautifulSoup import BeautifulSoup
from urlparse import urljoin
import urllib2
import argparse
import re
import codecs
import time
import random
import sys
import csv


cities=["Champaign"]
longitude="87.62979889"
latitude="40.11642074"
get_city_restaurants_page_0=\
    lambda latitude, longitude: \
    'https://www.grubhub.com/search?orderMethod=delivery&locationMode=DELIVERY&facetSet=umamiV2&pageSize=20&hideHateos&latitude={0}&longitude={1}'\
    '&facet=open_now:true&facet=price_rating:2.0&variationId=default-impressionScoreViewAdjSearchOnlyBuffed-20160607&sortSetId=umamiV2'\
    '&sponsoredSize=3&countOmittingTimes'.format(latitude, longitude)
  
get_city_restaurants_pages=\
    lambda latitude, longitude, page_num: \
    'https://www.grubhub.com/search?orderMethod=delivery&locationMode=DELIVERY&facetSet=umamiV2&pageSize=20&hideHateos&latitude={0}&longitude={1}'\
    '&facet=open_now:true&facet=price_rating:2.0&variationId=default-impressionScoreViewAdjSearchOnlyBuffed-20160607&sortSetId=umamiV2'\
    '&sponsoredSize=3&countOmittingTimes'\
    '&pageNum={2}&searchId=092350b2-0912-11e7-bc52-8d3cd17fb398'.format(latitude, longitude,page_num)



def crawl():
    page = 0
    flag = True
    #some_zipcodes = [zipcode] if zipcode else get_zips()

    totalRes=0

    # if zipcode is None:
    #     print '\n**We are attempting to extract all zipcodes in America!**'

    print "here"
    for city in cities:
        print '\n===== Attempting extraction for city <', city, '>=====\n'
        extracts=[]
        while flag:
            extracted, flag = crawl_page(latitude,longitude,page)
            if not flag or totalRes>20:
                OutputExtracted(extracts)
                print 'extraction stopped or broke at zipcode'
                break
            page += 1
            totalRes+=10
            extracts.append(extracted)
            time.sleep(random.randint(1, 2) * .931467298)





def crawl_page(latitude,longitude, page_num, verbose=True):
    """
    This method takes a page number, yelp GET param, and crawls exactly
    one page. We expect 10 listing per page.
    """
    try:
        if(page_num==0):
            page_url = get_city_restaurants_page_0(latitude, longitude)
        else:
            page_url= get_city_restaurants_pages(latitude,longitude,page_num)
        soup = BeautifulSoup(urllib2.urlopen(page_url).read())
    except Exception, e:
        print str(e)
        return []

    # restaurants = soup.findAll('ghs-search-item', attrs={'class':re.compile
    #         (r'^searchResult fadeIn')})
    # divs = soup.findAll('div',attrs={'class':re.compile(r'^innerWrapper clearfix content-transition')})
    divs = soup.findAll('div')
    for div in divs:
    	if div.text=='ng-view':
    		print div
    try:
        assert(len(divs) ==10)
        print "10 restaurants extracted"
    except AssertionError, e:
        # We make a dangerous assumption that yelp has 10 listing per page,
        # however this can also be a formatting issue, so watch out
        print 'end of search', str(e)
        print len(divs)
        print divs
        sys.exit(-1)
        # False is a special flag, returned when quitting
        return [], False

    extracted = [] # a list of tuples
    for r in restaurants:
        img = ''
        yelpPage = ''
        title = ''
        rating = ''
        addr = ''
        phone = ''
        categories = ''

        try:
            img = r.div('div', {'class':'media-avatar'})[0].img['src']
        except Exception, e:
            if verbose: print 'img extract fail', str(e)
        try:
            title = r.find('a', {'class':'biz-name js-analytics-click'}).getText()
            print title
        except Exception, e:
            if verbose: print 'title extract fail', str(e)
        # try:
        #     yelpPage = r.find('a', {'class':'biz-name js-analytics-click'})['href']
        #     print yelpPage
        # except Exception, e:
        #     if verbose: print 'yelp page link extraction fail', str(e)
        #     continue
        try:
            categories = r.findAll('span', {'class':'category-str-list'})
            categories = ', '.join([c.getText() for c in categories if c.getText()])
            print categories
        except Exception, e:
            if verbose: print "category extract fail", str(e)
            sys.exit(-1)
        try:
            rating = r.div('div', {'class':re.compile(r'^i-stars')})[0].img['alt'].split(' ')[0]
        except Exception, e:
            if verbose: print 'rating extract fail', str(e)
            sys.exit(-1)

        try:
            addr = r.find('div', {'class':'secondary-attributes'}).address.getText()
            print addr
        except Exception, e:
            if verbose: print 'address extract fail', str(e)
            
        try:
            price=r.find('div', {'class':"price-category"}).span.getText()
            print price
        except Exception, e:
            if verbose: print 'price extract fail', str(e)
            sys.exit(-1)         

        time.sleep(random.randint(1, 2) * .931467298)



        print '=============='
 
        extracted.append((title, categories, rating, img, addr,price))

    return extracted, True


if __name__ == '__main__':
	crawl()
  
   		