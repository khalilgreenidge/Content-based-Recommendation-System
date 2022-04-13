# Content-based Recommendation System

The following project contains a web application that leverages Artificial Intelligence such as Machine Learning, Natural Language Processing, and Information Retrieval. The following contains a detailed guide on how to run my project.

## Languages
- PHP *version 7.3.2*
- Python *version 3.9*
- Javascript *version 1.7* 
- Html 5
- CSS
- Ajax
- MariaDB (MySQL) *version 10.1.38*

## Environments
- Google Chrome *version 92.0.4515.159*
- ApacheFriends XAMPP *version 3.2.2*
- PyCharm Community Edition *version 2021.1.2*

## Libraries
- SciKit-Learn *version 0.24.2*
- PHP Random Name Generator 
- NLTK *version 3.6.2* 
- Pandas *version 1.3.0*
- Numpy *version 1.21.0*
- Calendar
- Re 

## Getting Started
This project was built with the flexibility of running either: via the 
Command-line Interface (static version for testing the two algorithms) or 
via the web-based Graphical User Interface (GUI).

## Command-line Interface
The command line version of the project has been split into
two different Python scripts (files) for the two algorithms. These 
files can be found in the "Python" folder. Within this folder, you will see
KNN-static.py, and CosineSimilarity-static.py. These are the files 
that use the self-titled algorithms. Both of these files depend on the
"Job Description.txt" and "SmallDataset2.csv" files. The "Job Description.txt"
file contains the use-case job description described in the dissertation/report.
The "SmallDataset2.csv" file contains the dataset used to build the 
model for both algorithms. The results described in the "Results" Section
of the report was produced using these files.

#### Feature Reduction and N-gram Manipulation
In order to test the experiment Feature Reduction or N-grams Manipulation
on either algorithm you must go this line:

```feature
tfidf = TfidfVectorizer(stop_words='english', ngram_range=(1,1), max_features=1000)
```

To reduce the number of features, simple change `max_features` to 
any of the numbers shown in the "Results" table under Feature 
Reduction Subsection. In order to reset to the default number of 
features, simply remove the `max_features` parameter from the
method.

As for changing the ngrams, you do this by changing `ngram_range()` 
to either `(1,1)` for unigrams, `(2,2)` for bigrams, `(3,3)` for 
trigrams, `(4,4)` for four-grams, or `(5,5)` for five-grams.
     
 
#### Hyperparameter Tuning
The hyperparameter tuning was conducted on the KNN algorithm, which 
can be found in the "KNN-static.py" file. To change the number of 
neighbours, simply go to line:

```markdown
k=5
clf = KNeighborsClassifier(n_neighbors=k)
```

At the above line, you can change the *k* to the desired number of neighbours
shown in the Results table.


#### Top-N Recommendations
For the Top-N recommendations experiment, this can be tested by going
to the following line of the "CosineSimilarity-static.py" file:

```markdown
n = 10  # Change me to change the Top-N recommendations.
results = results[1:n+1]
```

As shown above, this is set to a default of 10. Feel free to change
this number to test the results shown in the table of the Results
Section.


## Web-Base GUI

*Disclaimer: I will assume you are using a Windows Machine :)*

In order to run the web-based GUI, you will need to install ApacheFriends'
XAMPP. Afterwards, go to "*http://localhost/phpmyadmin/*", click "**import**"
at the top of the screen. Within that window, look for the "File to import:" 
window pane and browse to the sql file in this repository. Sometimes,
when importing an .sql file requires adding another line of code to create
the database but http://www.stackoverflow.com is very helpful. Hopefully, this won't be necessary and you will be able to
smoothly import the database. Nevertheless, if you have successfully
loaded the database, the name "mscproject" should appear as the 
database name. 

Next, you'll need to clone the entire repository on your local machine, 
into the "*htdocs*" folder, which is a subfolder within the XAMPP folder
that is automatically created when you install ApacheFriends XAMPP.

After you have cloned everything, go to http://localhost/Content-based-Recommendation-System/signin.php in your
Google Chrome browser. 

You should be presented with a screen that looks like this:

![Image showing signin.php page](imgs/signin.jpg "Signin Page")


###Signin Page
Use these credentials to gain access:

**Username**: admin                 \
**Password**: P@ssw0rd

You be directed to the dashboard page.  


### Dashboard Page 

![Image showing dashboard.php page](imgs/dashboard.jpg "Dashboard Page")

On the page, you will be able to see the campaign discussed in the 
"Use-Case" Section inside the report. From this window you can see some
candidates that have been randomly generated from the "LargeDataset.csv"
file which is the original dataset described in the "Resources" section
of the report.

From here you can simply click "View all Candidates".


### View All Candidates

![Image showing allcandidates.php page](imgs/allcandidates.jpg "All Candidates Page")

Inside this page, click the orange "Generate" button at the top to generate some candidates
randomly. You will be presented with a screen to enter the number of 
candidates you would like to generate. 

![Image showing generate popup](imgs/generate.jpg "Generate popup")

Enter a value then click done. Simply choose which algorithm you would
like to use for the recommendations by clicking either of the two
**blue** buttons at the top.

### Results Page
You would then be able to see results of the recommendations. For
example, if you select the KNN algorithm, you should be presented 
with a screen that looks like this:

![Image showing the candidates being classified](imgs/knn-predict.jpg "Results Page")


### Problems?
Feel free to email me at khalilgreenidge16@gmail.com and I will try to help.
Thank you.