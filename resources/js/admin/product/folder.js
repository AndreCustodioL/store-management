// $(document).ready(function() {
//     $('#categoria').on('focus', function() {
//         // Verifica se o select já foi populado anteriormente
//         if ($(this).find('option').length > 1) {
//             return;
//         }

//         // Envia a requisição AJAX ao servidor
//         $.ajax({
//             url: 'get-categorias.php', // URL do seu endpoint
//             type: 'GET',
//             dataType: 'json',
//             success: function(data) {
//                 // Limpa as opções atuais (exceto a primeira)
//                 $('#categoria').find('option:not(:first)').remove();

//                 // Itera sobre os dados recebidos e adiciona as opções ao select
//                 $.each(data, function(key, categoria) {
//                     $('#categoria').append('<option value="' + categoria.id + '">' + categoria.nome + '</option>');
//                 });
//             },
//             error: function(xhr, status, error) {
//                 console.error('Erro ao carregar as categorias:', error);
//             }
//         });
//     });
// });

//Ainda vou pensar se uso isso ou já renderizo direto na página
//Esse cód serve para puxar as categorias do cadastro da loja sem ter que carregar isso de uma vez quando entrar na página
//Mas provavelmente vou adotar a ideia de renderizar direto do php, espero que isso não fique lento com o tempo
