Esse repositório contém o meu Trabalho de Graduação do curso de Engenharia da Computação.

No trabalho, foi desenvolvido um interpretador de Português Estruturado em Python, que foi disponibilizado em um sistema também desenvolvido para o TCC, que permite o envio de códigos nas linguagens C, C++, Java, Python2, Python3 e Português Estruturado.


O trabalho foi desenvolvido para ajudar os professores a corrigirem exercícios de alunos, então é possível configurar as entradas e saídas esperadas no sistema.
Assim, quando o aluno entrar e enviar o código, o mesmo será compilado e executado com as entradas configuradas e a saída será comparada com a saída esperada.

O arquivo interpretador.html é a página principal.

O código é recebido por ele e enviado para o recebe.php, que faz as verificações, salva o código na pasta codes e compila e executa o arquivo. No final, ele executa um diff com a saída gerada e o arquivo saida.txt.

O arquivo projeto.py é o interpretador de Português Estruturado.
