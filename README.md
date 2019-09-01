# Domain Contacts

To-Do List:

- Add Integration and Unit tests.
- Missing migration files.
- Add missing documentations / Improve.
- Improve JWT Datatype structure.
- Create a mapper between algorithm verification in \openssl_verify.
- Review Requests/validator (validations happening twice).
- Have own dependency injection in the domain or create factories.

Hello there,

This is my playground to study/practice Domain-Driven-Design (DDD) software development and also Design Patterns.

The goal of this repository is to provide a Domain with all Business Logic with the minimum dependencies so that if we 
want the same functionality implemented in any framework from Laravel, CodeIgniter, WordPress, Joomla and so on, the duplication 
of code would be minimum because we have all logic in the same place, easy to adapt.

This Contacts List functionality is relative simple, and probably if the idea is just to have it, with a framework like Laravel
the problem could be solved way faster compared with this DDD approach, but if the projects keeps growing in complexity, and has to be
maintainable to multiple frameworks, with tests, the production will decrease with code duplication.

In this project I will try to implement many approaches even if they are not necessary, because the idea here is to have a playground
to experiment, try to understand the necessity of them and learn how to implement them. Right now I'm reading 3 books that I will be base my code on:
- Domain-Driven Design by Eric Evans (2003)
- Domain-Driven Design by Carlos Buenosvinos, Chhristian Soronellas, Keyvan Akbary (2018)
- Professional PHP by Patrick Louys

I will try to explain all decisions in the code and all feedback will be greatly appreciated, feel free to create issues if you find any.

You can contact me on Linkedin: https://www.linkedin.com/in/nuno-lopes/
