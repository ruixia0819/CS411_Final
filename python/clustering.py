
import math,sys,json

name_list=[]
K=3

def get_cos_distance(vec1, vec2):
	sumxx, sumyy, sumxy=0.0, 0.0, 0.0
	for i in range(len(vec1)):
		x=vec1[i];
		y=vec2[i];
		print "x:" +str(x)+" "+str(i);
		print "y:" +str(y)+" "+str(i); 
		sumxx+=x*x
		sumyy+=y*y
		sumxy+=x*y
		print str(x*y);
		print "sum:"+str(sumxy);
	if sumxx==0 or sumxy==0:
	    return float('Inf')
	else:
	    print "xy"+str(sumxy)
	    print "xx"+str(sumxx)
	    print "yy"+str(sumyy)
	    return math.log(sumxy)-(math.log(sumxx)+math.log(sumyy))

def get_vectors(all_users, cur_user):
	list_all=[]
	for usr_name in all_users.keys():
	    sub_dict=all_users[usr_name]
	    name_list.append(usr_name)
	    list_user=[]
	    for cats in sub_dict.keys():
			list_user.append((cats,sub_dict[cats]))
	    list_all.append(list_user)
	all_users=list_all

	list_cur=[]
	for cat in cur_user:
		list_cur.append((cat,int(cur_user[cat])))
	cur_user=list_cur
	

	m=len(all_users)
	total_categories=dict()
	idx=0
	total_weights=[]

	for i in range(m):
		cur=all_users[i]
		cur_freq_total=0.0
		cur_weights=[]
		cat_freq_dict={}

		for j in range(len(cur)):
			record=cur[j]
			category=record[0]
			categories=category.split(',')
			freq=int(record[1])


			for k in range(1,len(categories)):
				if categories[k] in cat_freq_dict:
					cat_freq_dict[categories[k]]=cat_freq_dict[categories[k]]+freq
				else:
					cat_freq_dict[categories[k]]=freq

				# give the current category an index in the total categories vector
				if categories[k] not in total_categories:
					total_categories[categories[k]]=idx
					idx+=1
				cur_freq_total=cur_freq_total+freq

			for cat in cat_freq_dict:
				cur_weights.append((total_categories[cat],cat_freq_dict[cat]))  #for each category, it stores its idx in the total array and the freq

		cur_weights=list(map(lambda x: (x[0],x[1]/float(cur_freq_total)),cur_weights)) # map the (index, freq) pair to (index, weight), where weight=freq/total_freq

		total_weights.append(cur_weights)

	total=len(total_categories)
	ret_vec=[]


	for i in range(len(total_weights)):
		tmp=[0]*total
		cur_weight=total_weights[i]
		for rec in cur_weight:
			tmp[rec[0]]=rec[1]
		ret_vec.append(tmp)



	# update: split out each category of a user history record
	tgt_cat_freq={}
	usr_total_freq=0
	
	for rec in cur_user:
	    cats=rec[0].split(',')
	    freq=rec[1]
	    for cat in cats:
	       # print(cat)
	        if cat not in tgt_cat_freq:
	           # print(cat)
	           # print(usr_total_freq)
	            tgt_cat_freq[cat]=freq
	            usr_total_freq=usr_total_freq+freq
	        else:
	            tgt_cat_freq[cat]=tgt_cat_freq[cat]+freq
	            usr_total_freq=usr_total_freq+freq
	
# 	for i in range(len(cur_user)):#rec in cur_user:
# 	    rec = cur_user[i]
# 	    cats=rec[0].split(',')
# 	    for j in range(len(cats)):
# 	        cat = cats[j]
# 	        #cat in cats:
# 	        print(rec)
# 	        print(tgt_cat_freq)
# 	        print("a" + str(usr_total_freq))
# 	        print(str("a") + cat)
# 	        a = (cat not in tgt_cat_freq)
# 	        if cat in tgt_cat_freq:
# 	            print(str("b") + cat)
# 	            tgt_cat_freq[cat]=tgt_cat_freq[cat]+rec[1]
#     	        usr_total_freq=usr_total_freq+rec[1]
    	        
#     	    else:
#     	        print("c" + cat)
#     	        print(usr_total_freq)
#     	        tgt_cat_freq[cat]=rec[1]
#     	        usr_total_freq=usr_total_freq+rec[1]
#     	        print(usr_total_freq)

    
    
	# cur_user_total=sum(list(map(lambda x:x[1], cur_user)))
	

	cur_user=list(map(lambda x: (x, tgt_cat_freq[x]/(usr_total_freq+0.0)),tgt_cat_freq))

	
	
	user_ret=[0]*total
	for rec in cur_user:
		if rec[0] in total_categories:
		    user_ret[total_categories[rec[0]]]=rec[1]
	
	return ret_vec, user_ret
    


def get_clustering_result(all_vec, user_vec):
	dist=[]
	for i in range(len(all_vec)):
		cur_vec=all_vec[i]

		    
		cur_dist=get_cos_distance(cur_vec,user_vec)
		dist.append((cur_dist,i))

	list.sort(dist)
	dist=dist[0:K+1]
	ret=list(map(lambda x: name_list[x[1]],dist))

	return ret;


if __name__ == '__main__':

	if len(sys.argv)!=3:
		print('ERROR USAGE: [clustering.py] [all_users list] [target user vector]')

	all_users=json.loads(sys.argv[1])
	cur_user=json.loads(sys.argv[2])

	all_features, user_feature=get_vectors(all_users,cur_user)
	res=get_clustering_result(all_features,user_feature)
	print(json.dumps(res))
	



