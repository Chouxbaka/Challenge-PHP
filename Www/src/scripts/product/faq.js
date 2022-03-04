import axios from 'axios';
export const expFaq = class faqConn{

    //-------ATRIBUT-------//

    constructor(){

    }

    load(question, answer){
        return new Promise((resolve, reject) => {
          const url = "http://localhost/projet-php-IsmaelHK1/Www/src/backend/faq/faq.php"
            axios.post(url, {
              params: {
                id: id
              }
            })
            .then(function (response) {
              resolve(response)
              console.log(resolve(response))
            })
            .catch(function (error) {
              console.log(error);
            }) 
          }
        )}
    }