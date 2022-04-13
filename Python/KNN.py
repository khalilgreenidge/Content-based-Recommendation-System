"""
- Author: Khalil Greenidge
- Date: September 1st, 2021
- Title: KNN with Resumes
- Description: Using KNN to classify résumés according to a model, as suitable or less suitable
"""

import sys
import mysql.connector
import nltk
import numpy as np
import pandas as pd
import re
from nltk import WordNetLemmatizer, word_tokenize
from sklearn.feature_extraction.text import TfidfVectorizer
import calendar
#import ML as ML  #Python has problems with this
from sklearn.model_selection import train_test_split
from sklearn.neighbors import KNeighborsClassifier
import sklearn.metrics as metrics


pd.set_option('display.max_columns', None)
tfidf = TfidfVectorizer(stop_words='english')  # remove stop words and vectorize resume feature


db = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="mscproject"
)

#get cursor
cursor = db.cursor()

#print("Hello world")



# print Applicants from Job campaign 1
cid = 1
#cid = sys.argv[1]

sql = "SELECT name,resume FROM applicants WHERE campaign_id = %s"
cursor.execute(sql, (cid,))
raw = cursor.fetchall()

dataset = pd.DataFrame(raw, columns=['name', 'resume'])

#1 GATHER THE DATA
train_dataset = pd.read_csv('SmallDataSet.csv', header=0, encoding_errors='replace')


# 1              DATA PRE-PROCESSING

lemmatizer = WordNetLemmatizer()
vocab = ["education", "year", "years", "yr", "yrs", "yearly", "month", "mth", "mths", "months", "monthly"]
vocab += np.array(calendar.month_name).tolist()
vocab = list(filter(None, vocab))
vocab = [a.lower() for a in vocab]

def preprocess(thedataset):
    thedataset.dropna()  # removes NaN
    thedataset.drop_duplicates(inplace=True)  # removes duplicates
    thedataset = thedataset.reset_index()  # reset the index
    return thedataset


def clean(text):
    text = str(text)
    text = re.sub(r'http\S+', '', text)  # remove hyperlinks - line adopted from (Tolgayilmaz, 2016)
    text = re.sub(r'[\w.+-]+@[\w-]+\.[\w.-]+', '', text)  # remove emails - line adopted from (Google Developers, 2018)
    text = re.sub("[^a-zA-Z ]+", ' ', text)  # remove punctuations, non-ascii, numbers and whitespace characters (Mateus, 2017)
    text = re.sub("  ", ' ', text)
    text = re.sub("  ", ' ', text)
    text = text.strip()
    text = text.lower()
    word_list = word_tokenize(text)
    text = ' '.join([lemmatizer.lemmatize(w) for w in word_list])  #
    text = ' '.join([t for t in text.split(" ") if t not in vocab and len(t) != 1])  # remove words from a custom vocabulary I build
    return text


#1. Preprocess
dataset = preprocess(dataset)
train_dataset = preprocess(train_dataset)


#2. Clean
dataset["resume"] = dataset["resume"].apply(lambda x: clean(x))
train_dataset["Resume"] = train_dataset["Resume"].apply(lambda x: clean(x))



#3.       BUILD KNN MODEL

#training data
X = tfidf.fit_transform(train_dataset['Resume']) #creates a bag of words and converts it to numbers
y = train_dataset["Class"]

#test data aka applicants
test_applicants = tfidf.transform(dataset['resume'])


#Split 80/20
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.20, stratify=y, random_state=0)


#Build Model
k = 9
clf = KNeighborsClassifier(n_neighbors=k)
clf.fit(X_train, y_train)
prediction = clf.predict(X_test)


predictions = clf.predict(test_applicants)

results = pd.DataFrame({
    "name": dataset["name"],
    "class": predictions
})

#print(results)
print(results.to_json())
#"""


