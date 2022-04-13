import numpy as np
import pandas as pd
from sklearn.metrics import classification_report as report
from sklearn.metrics.pairwise import cosine_similarity
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import linear_kernel
from nltk.stem import WordNetLemmatizer
from nltk.tokenize import word_tokenize
import re
import calendar
import time

start = time.time() #start timer

pd.set_option('display.max_columns', None)
pd.set_option('max_colwidth', 700)

#1 GATHER THE DATA
jdFile = open("..\\Job Description.txt", "r")
jd = jdFile.read()

df1 = pd.DataFrame({
    "Resume": [jd],
    "Class": ["BLANK"]
})
df2 = pd.read_csv('SmallDataSet2.csv', header=0, encoding_errors='replace')

dataset = pd.DataFrame([], columns=['Resume', "Class"])
dataset = dataset.append(df1)
dataset = dataset.append(df2)
dataset.drop('Category', inplace=True, axis=1)


#2              DATA PRE-PROCESSING

dataset.dropna()  # removes NaN
dataset.drop_duplicates(inplace=True)  # removes duplicates
dataset = dataset.reset_index()  #reset the index
lemmatizer = WordNetLemmatizer()
vocab = ["education", "exprience", "year", "years", "yr", "yr", "yearly", "month", "mth", "mths", "months", "monthly"]
vocab += np.array(calendar.month_name).tolist()
vocab = list(filter(None, vocab))
vocab = [a.lower() for a in vocab]


#row cleaning
def clean(text):
    text = str(text)
    text = re.sub(r'http\S+', '', text)  #remove hyperlinks - line adopted from (Tolgayilmaz, 2016)
    text = re.sub(r'[\w.+-]+@[\w-]+\.[\w.-]+', '', text) # remove emails - line adopted from (Google Developers, 2018)
    text = re.sub("[^a-zA-Z ]+", ' ', text)  # remove punctuations, non-ascii, numbers and whitespace characters (Mateus, 2017)
    text = re.sub("  ", ' ', text)
    text = re.sub("  ", ' ', text)
    text = text.strip()
    text = text.lower()
    word_list = word_tokenize(text)
    text = ' '.join([lemmatizer.lemmatize(w) for w in word_list]) #
    text = ' '.join([t for t in text.split(" ") if t not in vocab and len(t) != 1]) #remove words from a custom vocabulary I build

    return text


dataset["Resume"] = dataset["Resume"].apply(lambda x: clean(x))  # (Kharwal, 2020) - see references

#FEATURE EXTRACTION
tfidf = TfidfVectorizer(stop_words='english', ngram_range=(1,1), max_features=1000) # change me to test n-grams and feature reduction

# Construct the TF-IDF matrix by applying the fit_transform method on the resume feature
resume_matrix = tfidf.fit_transform(dataset['Resume']) # (Garodia, 2020) - see references


#3.           CREATE TOP-N RECOMMENDATION

cosine_sim = linear_kernel(resume_matrix, resume_matrix) # (Garodia, 2020) - see references
jd_index = 0

# similarity_score is the list of index and similarity matrix
similarity_score = list(enumerate(cosine_sim[jd_index])) # (Garodia, 2020) - see references

# sort in descending order the similarity score of resumes inputted with all the other resumes
similarity_score = sorted(similarity_score, key=lambda x: x[1], reverse=True) # (Garodia, 2020) - see references
indices = [i[0] for i in similarity_score]
scores = [i[1] for i in similarity_score]


results = pd.DataFrame({
    "Index": indices,
    "Recommendation": dataset["Resume"].iloc[indices],  #Uncomment to see the actual résumés
    "Cosine": scores
})
results = results.reset_index(drop=True)


# Get the top N recommendations. Ignore the first document which is the job description.
n = 10  # Change me to change the Top-N recommendations.
results = results[1:n+1]
print("\nResults: \n", results)



# 4. EVALUATE ALGORITHM - DISPLAY EVALUATION METRICS

y_true = dataset["Class"].iloc[indices][1:n+1] #Get the true target classes for items in the list

global relevant
relevant = 0
for x in y_true:
    if x == "Suitable":
        relevant += 1


def findRecall(k):
    totalRelevant = dataset.groupby('Class').size()[2]
    therecall = relevant / totalRelevant if totalRelevant != 0 else 0
    return therecall

def findPrecision(k):
    theprecision = relevant / k if k != 0 else 0
    return theprecision

def findFMeasure(precision, recall):
    f = (2 * precision * recall)/(precision + recall)
    return f

def findIntr(data):
    sum = 0
    for x in data:
        sum += x
    return sum / data.shape[0]

# Print a Custom Report I Created
print("\n\n\t\t\t Evaluation Metrics For Top N =",n,"Recommendations\n")
print(
"Precision  @ k: \t%.2f" %  findPrecision(n),
"\nRecall     @ k: \t%.2f" %  findRecall(n),
"\nF1-Score   @ k: \t%.2f" %  findFMeasure(findPrecision(n), findRecall(n)),
"\n\nFeatures: ", resume_matrix.shape[1],
"\nN-grams: ", tfidf.ngram_range[1],
"\nIntra-list similarity:  %.3f" % findIntr(results["Cosine"].values),)

end = time.time() #stop stopwatch
print("Time taken: \t\t %.3f" % (end-start),"secs")
#"""
