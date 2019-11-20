# Domain Contacts

Hello there,

This is my playground to study/practice Domain-Driven-Design (DDD) software development and also Design Patterns.

There will be other repositories for this project:

Laravel Package Repository:
- This Repository will be the application layer, a package for laravel that will be used mainly for Binding Contracts, 
Controllers and raising exceptions. It will be the API, no business logic should be there. The repository is working right now but doesn't have 
tests right now or documentation so it is not available right now. With postman later it should be able to test the API.

React Repository:
- In my current company I've have experience with JavaScript ES6, creating small aplications, and as Backend Developer till the moment, I found
  very interesting and decided to explore more the frontend area, lately I've been in a course in Udemy of React/Redux. Which I will apply
  the best code I can there. The same as the Laravel Package, it is working but it lacks documentation and tests and so it is not available
  right now.

The goal of this repository is to provide a Domain with all Business Logic with the minimum dependencies so that if we 
want the same functionality implemented in any framework from Laravel, CodeIgniter, WordPress, Joomla and so on, the duplication 
of code would be minimum because we have all logic in the same place, easy to adapt.

This Contacts List functionality is relative simple, and probably if the idea is just to have it, with a framework like Laravel
the problem could be solved way faster compared with this DDD approach, but if the projects keeps growing in complexity, and has to be
maintainable to multiple frameworks, with tests, the production will decrease with code duplication.

#Instalation
- To build the tables, run `composer run-script migrations`
- To seed the tables with dummy data for testing: `composer run-script seed`
- To rollback all migrations: `composer run-script migrations-rollback`

In this project I will try to have always 100% code coverage inside the `src` folder, integration and unit tests will make sure that the code is 
SOLID and every line is beeing used, also avoiding errors in future developments. The coverage shouldn't be with with non-sense 
tests to accomplish the 100% mark, doing the needed tests of the code will bring the coverage.

In this project I will try to implement many approaches even if they are not necessary, because the idea here is to have a playground
to experiment patterns, architectures, ideas, try to understand the necessity of them and learn how to implement them. 

Right now I'm reading 2 books that I will be base my code on:
- Domain-Driven Design by Eric Evans (2004)
- Design Patterns Elements of Reusable Object-Oriented Software by Erich Gamma, Richard Helm, Ralph Johnson, John M. Vlissides (1994)

I will try to explain all decisions in the code and all feedback will be greatly appreciated, feel free to create issues if you find any.

You can contact me on Linkedin: https://www.linkedin.com/in/nuno-lopes/

To-Do List:

- Solve some @todo's in the code.
- Add run tests by composer run script.
- Bring again coverage to 100%

A special thanks to [@HRADigital]( https://github.com/HRADigital ), since without him couldn't have learned this much in this short
period of time, who mentored me and guided me during 18 months.
