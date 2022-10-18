var nome: caracter
var x: inteiro
var i: inteiro
var res: inteiro

nome = "Leandro"
x = 60 - 55

escreva ("Teste")
escreva ("Ola " + nome)
escreva ("x" + "=" + x)

se (x > 50) entao
    escreva ("x é maior que 50")
senao
    se (x < 10) entao
        escreva ("x é menor que 10")
    senao
        escreva ("x é maior que 10")
    fimse
fimse

para i de 0 ate 30 passo 2 faca
    escreva (i)
fimpara
i = 0
enquanto (i<=10) faca
    se (i % 2 == 0) entao
        escreva (i + " é par")
    senao
        escreva (i + " é ímpar")
    fimse
    i = i + 1
fimenquanto