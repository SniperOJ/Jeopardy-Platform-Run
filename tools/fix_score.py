#!/usr/bin/env python
# coding:utf-8

import MySQLdb

db = MySQLdb.connect("localhost","username","password","database")
cursor = db.cursor()

def get_score_by_challenge_id(challenge_id):
    cursor.execute("select score from challenges where challenge_id = %d" % (challenge_id))
    data = cursor.fetchone()
    return data[0]

def get_current_challenges_by_user_id(user_id):
    challenges = []
    cursor.execute("select challenge_id from submit_log where user_id = %d and is_current = 1" % (user_id))
    data = cursor.fetchall()
    for i in data:
        challenges.append(i[0])
    return challenges

def get_current_score_sum(user_id):
    challenges = get_current_challenges_by_user_id(user_id)
    score_sum = 0
    for i in challenges:
        score = get_score_by_challenge_id(i)
        score_sum += score
    return score_sum

def get_record_score_by_user_id(user_id):
    cursor.execute("select score from users where user_id = %d" % (user_id))
    data = cursor.fetchone()
    return data[0]

def get_all_user_id():
    users = []
    cursor.execute("select user_id from users")
    data = cursor.fetchall()
    for i in data:
        users.append(i[0])
    return users

def update_user_score(user_id, score):
    cursor.execute("update users set score=%d where user_id = %d" % (score, user_id))
    db.commit()

users = get_all_user_id()
bad_number = 0
for i in users:
    print "=" * 32
    record_score = get_record_score_by_user_id(i)
    current_score = get_current_score_sum(i)
    print "User : [%d]" % (i)
    print "[%d] <==> [%d]" % (record_score, current_score)
    if record_score != current_score:
        print "[!] Not current!"
        print "[+] Fixing..."
        update_user_score(i, current_score)
        print "[+] Fix finished!"
        bad_number += 1

print "[+] Check finished!"
print "[+] Bad number : [%d]" % (bad_number)




db.close()
