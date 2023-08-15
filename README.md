# Instalação

Faça um git clone no repositorio desejado usando o seguinte comando
```git
git clone https://github.com/felpsgus/project-laravel.git
```

Navegue até o diretório onde foi feito o clone, abra o terminal e digite os seguintes comandos

```git
cd apiEnderecos

php artisan migrate

php artisan serve --port=8000
```

Ainda no terminal, digite

```git
cd..

cd vue

npm install

npm run dev
```

Após, isso navegue até [http://localhost:5173/](http://localhost:5173/)

[MIT](https://choosealicense.com/licenses/mit/)