##About


Forked by George Edison
---
StackTack is a widget for bloggers and writers to easily tack questions and answers from the Stack Exchange sites such as Stack Overflow, Server Fault and Super User, into their articles. The widget remains up to date as answers get added, modified, voted on and accepted.

It works by finding HTML elements with an id similar to "stacktack-518021" where the number is a Stack Exchange question ID.  The widgets are then generated inside these containers.  

The widgets can be heavily customized, both globally and on a per-question basis. Stylesheets can be overridden to change the appearance and answers can be filtered in many different ways.

**See it in action with our [live demo][3].**

Complete information and instructions are available here on the [StackTack Wiki][4].

###License

BSD - Do with it what you will, but please give Zamtools credit and please let us know what you're doing with it. We're curious to see how people use this.



###Platform

StackTack is intended for use on web pages, blogs and articles.  Anywhere an author may want to include a Stack Exchange question.

###Contact

Bug reports and communications can be made on the [StackTack BitBucket bug tracker][5] or the github issues page.

###Code

StackTack is written in JavaScript and jQuery and consumes the Stack API directly via Ajax requests. The source can be found at the [StackTack BitBucket repository][6] and the Git repository above.

StackTack has also been integrated into the [SAggregator][7] created by [Farseeker][8].

  [2]: http://img24.imageshack.us/img24/417/captureqi.png
  [3]: http://app.stacktack.com/index.html
  [4]: http://bitbucket.org/zamtools/stacktack/wiki/Home
  [5]: http://bitbucket.org/zamtools/stacktack/issues?status=new&status=open
  [6]: http://bitbucket.org/zamtools/stacktack/src
  [7]: http://stackapps.com/questions/570/saggregator-a-way-to-accumulate-all-the-latest-activity-from-the-stackapps-api
  [8]: http://stackapps.com/users/816/farseeker
