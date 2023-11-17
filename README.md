Como usar:
git clone https://github.com/CyberAPOKA/agendart.git

configurar o banco de dados com a .env (usar a .env.example como base)

rodar os comandos:
composer install
npm install

php artisan key:generate

abrir o servidor:
php artisan serve

deixar o npm rodando:
npm run dev

php artisan migrate --seed (--seed opcional), fiz seeds de usuários e posts.

para implementar as seeds de fotos, crie uma pasta posts/seeder dentro da storage/app/public, e adicione fotos png de 1 a 10, 1.png, 2.png etc...

php artisan storage:link

acessar a url http://127.0.0.1:8000/

Bibliotecas usadas:
https://jetstream.laravel.com/ para autenticação e configurações iniciais.
https://heroicons.com/ para ícones
https://github.com/brockpetrie/vue-moment para formatação de datas
https://laravel.com/docs/10.x/precognition para validação de formulário em tempo real com o backend
https://undraw.co/ para svgs
https://picturepan2.github.io/instagram.css/ para os filtros das imagens
https://agontuk.github.io/vue-cropperjs/ para recortar as imagens
https://github.com/hilongjw/vue-lazyload/tree/next para o lazy-load com vue 3
https://flowbite.com/ para alguns componentes e estruturas
https://tailwindcss.com/ para o front end (biblioteca css)
