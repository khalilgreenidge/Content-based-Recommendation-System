#importing necessary libraries
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
from sklearn.discriminant_analysis import LinearDiscriminantAnalysis
from sklearn.naive_bayes import GaussianNB
from sklearn.svm import SVC
import nltk
from nltk.stem import WordNetLemmatizer
import re
nltk.download('wordnet')
nltk.download('punkt')
pd.set_option('display.max_columns', None)

#1 GATHER THE DATA
jdFile = open("C:\\Users\\fresh\\OneDrive - University of Birmingham\\MSc. Project\\Data\\Resume-Screening-master\\Files\\Job Description.txt", "r")
jd = jdFile.read()

df1 = pd.DataFrame({
    "Resume": [jd],
})
df2 = pd.read_csv('C:\\Users\\fresh\\OneDrive - University of Birmingham\\MSc. Project\\Data\\Resume-Screening-master\\Files\\Small Resume DataSet.csv', header=0)
df3 = pd.DataFrame(df2["Resume"])
dataset = df1.append(df3, ignore_index = True)


#2              DATA PRE-PROCESSING

#cleaning
#print("This is the list:  \n", dataset.head(50))

dataset.dropna()  # removes NaN
dataset.drop_duplicates(inplace=True)  # removes duplicates
dataset = dataset.reset_index()  #reset the index
lemmatizer = WordNetLemmatizer()

#print("New shape is ", dataset.shape)

#row cleaning
def clean(text):
    text = re.sub(r'http\S+', '', text)       #remove hyperlinks
    text = text.replace("\n", " ") # replaces any \n characters
    text = re.sub('[%s]' % re.escape("""!"$%&'()*,-./:;<=>?@[]^_`{|}~"""), '', text)  # remove punctuations
    encoded_string = text.encode("ascii", "ignore")  #removes all non-ascii characters
    decode_string = encoded_string.decode()
    text = decode_string
    word_list = nltk.word_tokenize(text)
    text = ' '.join([lemmatizer.lemmatize(w) for w in word_list])
    #print("Here's a tokenised sentence: ", text)
    return text


dataset["Resume"] = dataset["Resume"].apply(lambda x: clean(x))
#print("\n\nThis is the cleaned set of resumes \n", dataset.head(6))


#LEMATISATION





#FEATURE EXTRACTION
tfidf = TfidfVectorizer(stop_words='english', sublinear_tf=True)

# Construct the TF-IDF matrix by applying the fit_transform method on the resume feature
resume_matrix = tfidf.fit_transform(dataset['Resume'])

#print("\nHere's the matrix: \n", pd.DataFrame(resume_matrix.toarray(), columns=tfidf.get_feature_names()).head(6).to_string )


#3.      EVALUATE ALGORITHM

# Make predictions on validation dataset using Cosine Similarity

cosine_sim = linear_kernel(resume_matrix, resume_matrix)
#print("\nHere is the similarity matrix for each resume: \n", cosine_sim)

#print("\nCosine Sim for Job Description: \n", cosine_sim[0])


# get similarity values with other movies
jd_index = 0

# similarity_score is the list of index and similarity matrix
similarity_score = list(enumerate(cosine_sim[jd_index]))
#print("\nSimilarity Scores: \n", similarity_score)

# sort in descending order the similarity score of resumes inputted with all the other resumes
similarity_score = sorted(similarity_score, key=lambda x: x[1], reverse=True)
indices = [i[0] for i in similarity_score]
scores = [i[1] for i in similarity_score]


results = pd.DataFrame({
    "index": indices,
    "recommendation": dataset["Resume"].iloc[indices],
    "cosine score": scores
})

# Get the scores of the 15 most similar resumes. Ignore the first document.
similarity_score = similarity_score[1:11]

# return resume index numbers
#print("\nRESULTS: \n", dataset.iloc[[i[0] for i in similarity_score]])

dict = results.head(5).to_html()

print("\nResults: \n", results.head(5).to_html())

#print("\nResume 4: \n", [dataset.iloc[16].to_string])
#"""
