import numpy as np
import pandas as pd
from sklearn import metrics
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.model_selection import train_test_split
from sklearn.neighbors import KNeighborsClassifier
from matplotlib import pyplot as plt
import nltk.tokenize
from nltk.stem import WordNetLemmatizer
import re
import calendar
import time

start = time.time()
pd.set_option('display.max_columns', None)

#1 GATHER THE DATA
dataset = pd.read_csv('SmallDataSet2.csv', header=0, encoding_errors='replace')


#2              DATA PRE-PROCESSING
dataset.dropna()  # removes NaN
dataset.drop_duplicates(inplace=True)  # removes duplicates
dataset = dataset.reset_index()  #reset the index
lemmatizer = WordNetLemmatizer()
vocab = ["education", "year", "years", "yr", "yrs", "yearly", "month", "mth", "mths", "months", "monthly"]
vocab += np.array(calendar.month_name).tolist()
vocab = list(filter(None, vocab))
vocab = [a.lower() for a in vocab]


#row cleaning
def clean(text):
    text = str(text)
    text = re.sub(r'http\S+', '', text)  # remove hyperlinks - line adopted from (Tolgayilmaz, 2016)
    text = re.sub(r'[\w.+-]+@[\w-]+\.[\w.-]+', '', text)  # remove emails - line adopted from (Google Developers, 2018)
    text = re.sub("[^a-zA-Z ]+", ' ', text)  # remove punctuations, non-ascii, numbers and whitespace characters (Mateus, 2017)
    text = re.sub("  ", ' ', text)
    text = re.sub("  ", ' ', text)
    text = text.strip()
    text = text.lower()
    word_list = nltk.word_tokenize(text)
    text = ' '.join([lemmatizer.lemmatize(w) for w in word_list])  #
    text = ' '.join([t for t in text.split(" ") if t not in vocab and len(t) != 1])  # remove words from a custom vocabulary I build
    return text

dataset["Resume"] = dataset["Resume"].apply(lambda x: clean(x))


#FEATURE EXTRACTION
tfidf = TfidfVectorizer(stop_words='english', ngram_range=(1,1)) #change me to test experiments


#3.      BUILD MODEL

#training data
X = tfidf.fit_transform(dataset['Resume']) #creates a bag of words and converts it to numbers
y = dataset["Class"]

#Split 80/20 using Stratified Sampling and 5 folds
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.20, stratify=y, random_state=0)  # (Brownlee, 2019) - see references

k=5
clf = KNeighborsClassifier(n_neighbors=k)


#Build Model
clf.fit(X_train, y_train) # (Brownlee, 2019) - see references


#prediction
prediction = clf.predict(X_test)
print('Accuracy of KNeighbors Classifier on training set: {:.2f}'.format(clf.score(X_train, y_train))) # (Brownlee, 2019) - see references
print('Accuracy of KNeighbors Classifier on test set: {:.2f}'.format(clf.score(X_test, y_test))) # (Brownlee, 2019) - see references

print("\n \t \t \t Classification Report for Test Set \nClassifier: %s \nn-gram_range: %s:\n\n%s\n" % (clf, str(tfidf.ngram_range), metrics.classification_report(y_test, prediction, labels=["Suitable", "Less Suitable"])))
end = time.time()
print("Time: ", (end-start))