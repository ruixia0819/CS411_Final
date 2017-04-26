#!/usr/bin/python
import sys,json



if __name__ == '__main__':

# 	if len(sys.argv)!=2:
# 		print('ERROR USAGE: [clustering.py] [all_users list] [target user vector]')
		


#     # Load the data that PHP sent us
#     try:
#         data = json.loads(sys.argv[1])
#     except:
#         print "ERROR"
#         sys.exit(1)
    
    # Generate some data to send to PHP
    result = "so sad :("
    if len(sys.argv)==2:
        result="oh yeah!!!!!"
    
    data=json.loads(sys.argv[1])
    if isinstance(data,dict):
        result="yeah!!!!!!!!!"
    else:
        result="no!!!!!!!"
    
    if data==None:
        result="NONE!"
    elif isinstance(data,str):
        result="STRING!"
    elif isinstance(data,dict):
        result=["DICTIONARY"]
    elif isinstance(data,unicode):
        result="UNICODE!"
    else:
        # result=str(type(data))
        result="I am a dictionary"
    
    # Send it to stdout (to PHP)
    
    print json.dumps(result)
    # print result

# 	cur_user=sys.argv[1]
# 	data_get=str(json.load(cur_user))
# 	result={'status':'yes!'}
# 	print(json.dump(result+"!!!!!"+data_get))
	# cur_user=sys.argv[2]

	# all_features, user_feature=get_vectors(all_users,cur_user)
	# res=get_clustering_result(all_features,user_feature)