## Todo

- Save checkout narration
- Middleware to check checkout variables
- Package to listen for events & email
- APIs for the 6 commands:
- `pay4app:balanceaudit` --on or --off
- `pay4app:auditbalance` set it
- `payapp:nullifyTransfer` [id] (show details in console, ask for confirmation)
- `pay4app:linkAndClose --checkout= --transfer=` (shows both details. Or they can comma separate transfer ids)
- `pay4app:linktransfer --checkout --transfer=` (attaches transer to checkout, but does not close it)
- `pay4app:close --checkout=` (closes a checkout without marking it paid so that subsequent transfers from same buyer do not pay for it.)
- API to fetch checkout and get its details as JSON dump response

---

>>>>

- [Webhook example](https://gist.github.com/boucher/1708172)
- [Stripe webhook docs](https://stripe.com/docs/webhooks)
- [Config mocking in Laravel](https://github.com/laravel/framework/issues/4072)
- [Creating Artisan commands](https://mattstauffer.co/blog/creating-artisan-commands-with-the-new-simpler-syntax-in-laravel-5.1)
- [Git ignore](http://laravel-recipes.com/recipes/31/managing-your-project-with-git), [also here](http://stackoverflow.com/questions/25748132/what-to-include-in-gitignore-for-a-laravel-and-phpstorm-project)
