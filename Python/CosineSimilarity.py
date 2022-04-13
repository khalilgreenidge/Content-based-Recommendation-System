import sys
import mysql.connector
import calendar
import numpy as np
import pandas as pd
import re
from nltk import WordNetLemmatizer, word_tokenize
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import linear_kernel


pd.set_option('display.max_columns', None)
lemmatizer = WordNetLemmatizer()
tfidf = TfidfVectorizer(stop_words='english')  # remove stop words and vectorize resume feature


db = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="mscproject"
)

#get cursor
cursor = db.cursor()


# get PHP campaign ID argument
cid = sys.argv[1]
#cid = 1

sql = "SELECT name,resume FROM applicants WHERE campaign_id = %s"
cursor.execute(sql, (cid,))
raw = cursor.fetchall()
df1 = pd.DataFrame(raw, columns=['name', 'document']) # populate df1 with applicants


#1 GATHER THE DATA
cursor.execute("SELECT overview,duties,requirements,keywords FROM campaigns")
result = cursor.fetchone()
jd = ""
for x in result:
    jd += x


dataset = pd.DataFrame(columns=["name", "document"])
dataset = dataset.append({
    "name": "job description",
    "document": jd
}, ignore_index=True)
dataset = dataset.append(df1, ignore_index=True) # append applicants table



# 1              DATA PRE-PROCESSING

#custom vocab
vocab = ["education", "exprience", "year", "years", "yr", "yr", "yearly", "month", "mth", "mths", "months",
         "monthly"]
vocab += np.array(calendar.month_name).tolist()
vocab = list(filter(None, vocab))
vocab = [a.lower() for a in vocab]

def preprocess(thedataset):
    thedataset.dropna()  # removes NaN
    thedataset.drop_duplicates(inplace=True)  # removes duplicates
    thedataset = thedataset.reset_index()  # reset the index
    lemmatizer = WordNetLemmatizer()
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

#2. clean
dataset["document"] = dataset["document"].apply(lambda x: clean(x))



#3. model
document_matrix = tfidf.fit_transform(dataset['document'])  # (Garodia, 2020) - see references


#3.      EVALUATE - Cosine Similarity

#Find Cosine Similarity
cosine_sim = linear_kernel(document_matrix, document_matrix)  # (Garodia, 2020) - see references

#reverse indexing
mapping = pd.Series(dataset.index,index = dataset["name"])   # (Garodia, 2020) - see references


# get similarity values with other movies
jd_index = mapping["job description"]


# similarity_score is the list of index and similarity matrix
similarity_score = list(enumerate(cosine_sim[jd_index]))   # (Garodia, 2020) - see references
#print("\nSimilarity Scores: \n", similarity_score)

# sort in descending order
similarity_score = sorted(similarity_score, key=lambda x: x[1], reverse=True)  # (Garodia, 2020) - see references
indices = [i[0] for i in similarity_score]
scores = [i[1] for i in similarity_score]


results = pd.DataFrame({
    "name": dataset["name"].iloc[indices],
    "cosine score": scores
})
results = results.reset_index(drop=True)

# Get the top N recommendations. Ignore the first document which is the job description.
n = 10  # Change me to change the Top-N recommendations.
results = results[1:n+1]
print(results.to_json())





