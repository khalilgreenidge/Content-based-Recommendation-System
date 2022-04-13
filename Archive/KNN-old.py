# importing necessary libraries
import numpy as np
import pandas as pd
from sklearn.metrics.pairwise import cosine_similarity
from sklearn.metrics import mean_squared_error
from sklearn.model_selection import train_test_split
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import linear_kernel
from sklearn.model_selection import train_test_split
from sklearn.model_selection import cross_val_score
from sklearn.model_selection import StratifiedKFold
from sklearn.metrics import classification_report
from sklearn.metrics import confusion_matrix
from sklearn.metrics import accuracy_score
from sklearn.linear_model import LogisticRegression
from sklearn.tree import DecisionTreeClassifier
from sklearn.neighbors import KNeighborsClassifier
from sklearn.naive_bayes import MultinomialNB
from sklearn.multiclass import OneVsRestClassifier
from sklearn import metrics
from sklearn.metrics import accuracy_score
from pandas.plotting import scatter_matrix
from sklearn.neighbors import KNeighborsClassifier
from sklearn import metrics
from sklearn.discriminant_analysis import LinearDiscriminantAnalysis
from sklearn.naive_bayes import GaussianNB
from sklearn.svm import SVC
from sklearn import preprocessing
import nltk
from nltk.stem import WordNetLemmatizer
import re
from sklearn.model_selection import train_test_split as tts
from sklearn.neighbors import KNeighborsClassifier as knn
from sklearn import metrics

# declare, initialise and set up variables
nltk.download('wordnet')
nltk.download('punkt')
pd.set_option('display.max_columns', None)
lemmatizer = WordNetLemmatizer()
tfidf = TfidfVectorizer(stop_words='english', sublinear_tf=True)  # remove stop words and vectorize resume feature
global model, X_train, X_test, y_train, y_test
X_test2 = [[]]


#  GATHER THE DATA
dataset = pd.read_csv('../SmallDataset.csv', header=0)


# 1              DATA PRE-PROCESSING

def preprocess(thedataset):
    thedataset.dropna()  # removes NaN
    thedataset.drop_duplicates(inplace=True)  # removes duplicates
    thedataset = thedataset.reset_index()  # reset the index
    return thedataset

def clean(text):
    text = re.sub(r'http\S+', '', text)  # remove hyperlinks
    text = text.replace("\n", " ")  # replaces any \n characters
    text = re.sub('[%s]' % re.escape("""!"$%&'()*,-./:;<=>?@[]^_`{|}~"""), '', text)  # remove punctuations
    encoded_string = text.encode("ascii", "ignore")  # removes all non-ascii characters
    decode_string = encoded_string.decode()
    text = decode_string
    word_list = nltk.word_tokenize(text)  # tokenisation
    text = ' '.join([lemmatizer.lemmatize(w) for w in word_list])  # lematisation and joining sentence
    # print("Here's a tokenised sentence: ", text)
    return text


# 3.      BUILD MODEL

"""
    # training and vectorize data
    X = tfidf.fit_transform(dataset['Resume'])  # creates a bag of words and converts it to numbers
    y = dataset["Class"]

    print("X: \n", [X])
    #print("\nY: \n", [y])

    #print("\n Split 80/20: ")

    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.20, random_state=1)
    X_test2 = X_test.copy()
    print("\nTest samples: ", X_test2)

    print("\nHere's the train shape: ", X_train.shape)
    print("\nHere's the test shape: ", X_test.shape)

    clf = OneVsRestClassifier(KNeighborsClassifier())
    clf = clf.fit(X_train, y_train)

    prediction = clf.predict(X_test)
    print('Accuracy of KNeighbors Classifier on training set: {:.2f}'.format(clf.score(X_train, y_train)))
    print('Accuracy of KNeighbors Classifier on test set: {:.2f}'.format(clf.score(X_test, y_test)))

    print("\n Classification report for classifier %s:\n%s\n" % (clf, metrics.classification_report(y_test, prediction)))

"""

def buildmodel2():
    # CREATE LABEL ENCODER
    le = preprocessing.LabelEncoder()

    # Converting string labels into numbers.
    encoded_y = le.fit_transform(dataset["Class"])

    # Splitting train/test data
    X = tfidf.fit_transform(dataset['Resume'])
    y = encoded_y

    X_tr, X_ts, y_tr, y_ts = tts(X, y, test_size=0.20, random_state=1)

    ###Creating kNN Classifier Model
    KNN = knn(n_neighbors=1)

    ###Training the Model
    KNN.fit(X_tr, y_tr)

    ###Making Predictions
    y_pr = KNN.predict(X_ts)

    ###Evaluating Prediction Accuracy
    print("Accuracy:", metrics.accuracy_score(y_ts, y_pr))

    ###Making Prediction with Foreign Data
    #print(KNN.predict([[1, 5, 3.5, 6]]))

    #test

    #print("Y-values: ", tests)

    #print(KNN.predict([[tests]]))


# run all the methods

#1.
dataset = preprocess(dataset)
# print("New shape is ", dataset.shape, ". It will appear as 1 less than the other script because we took out job description")

#2.
dataset["Resume"] = dataset["Resume"].apply(lambda x: clean(x))
# print("\n\nThis is the cleaned set of resumes \n", dataset.head(6))

#3.
buildmodel2()

#4
#makeprediction()  #the end