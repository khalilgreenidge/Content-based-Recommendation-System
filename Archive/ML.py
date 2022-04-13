import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer
import re
import nltk
from nltk.stem import WordNetLemmatizer

# declare, initialise and set up variables
#nltk.download('wordnet')
#nltk.download('punkt')
pd.set_option('display.max_columns', None)

lemmatizer = WordNetLemmatizer()
tfidf = TfidfVectorizer(stop_words='english', sublinear_tf=True)  # remove stop words and vectorize resume feature

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
