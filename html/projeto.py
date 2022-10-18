import sys, re
dic ={'se': '1', 'senao': '2', 'para': '3', 'enquanto': '4', 'faca': '5', 'senao se': '6', 'senao': '7', 'entao': '8', 'se': '9', ' e ': '10', ' ou ': '11', 'nao(': '12', 'verdadeiro': '13', 'falso': '14', 'escreva': '15', 'retorne': '16', 'var': '17', 'leia': '18', 'fimpara': '11', 'fimenquanto': '12', 'fimse': '13'}
global lines, dicionario

lines = []
dicionario = []
variables = {}

def pegaComando(comando):
    global dicionario
    for (comando_velho, comando_novo) in dicionario:
        if comando_velho == comando:
            return comando_novo


def main():
    global lines, dicionario

    filepath = sys.argv[1]
    filename = filepath[:filepath.rfind(".")]
        
    file = open(filepath,"r")
    
    for line in file :
        lines.append(line)
    if len(lines) < 1:
        print('Arquivo vazio')
        return
#analisador lexico
    linha = 1
    inst_n = []
    linha_err = []
    erro_sintaxe = False
    i=0
    for line in lines:
       #print(i)
       i = i+1
       #print(line)
       #if line == "\n":
       if len(line.strip()) == 0:
          linha = linha + 1
          continue
       #print(repr(line) + str(i))
       #i = i+1
       # Retirar espaçao em branco   
       linhacod = line.strip() # Captura a linha do código Fonte.
       space_index = linhacod.find(" ")
       #print (space_index)
       if space_index >= 0:
           linhacod = linhacod [0:space_index]  # Elimina o resto da linha pegando a Instrução
       #print(linhacod+"||")
       if line.strip()[space_index+1:space_index+2] == "=":
           #print("entrou " + line)
           linha = linha + 1
           continue
       achou = False
       for d in dic.keys():  # Captura as linhas de código e compara com dicionário.
           if linhacod.strip()== d:  # Elimina espaço em branco das linhas e compara.
              #print ("entremo")
              achou = True
              break
       #fim for       
       #print ""
       if achou == False:
          #print (line)
          inst_n.append(linhacod)  #Armazena linha de código Incorreta.
          linha_err.append(linha)  #Armazena o número da linha de código Incorreta.
          break

       #print ""
       linha = linha + 1   # Conta o número da linha de código.
       
    if achou == False:
       erro_sintaxe = True
       print("Erro: simbolo Inexistente => %s: linha: %s"%(inst_n[0],linha_err[0]))
       file.close()
       sys.exit(666)
    #fim for
    file.close() 
#gerador de codigo
    if erro_sintaxe == False:
        dicionario = [("fimenquanto","#end"), ("fimse","#end"), ("fimpara","#end"),("para", "for"), (" faca", ":"), ("enquanto", "while"), ("senao se ", "#end\nelif "), ("senao", "#end\nelse:"), ("entao", ":"), ("se ", "if "), ("funcao", "def"), (" e ", " and "), (" ou ", " or "), ("nao(", "not("), ("Verdadeiro", "True"), ("Falso", "False"), ("escreva", "print"), ("retorne", "return"), ("na", "in"), ("leia","input")]
        
        fonte  = open(filepath, 'r')
        #filename = '/var/www/html/html/codes/' + filename
        #print (filename)
        final = open(filename + ".py", "w+", encoding="utf-8")
        #final.write("def ler(texto):\n  t = input(texto)\n  if t.isdigit():\n    return float(t)\n  else:\n    return t\ndef texto(n):\n	return str(n)\n")
        conteudo_arquivo = []
        
        for linha in fonte:
            if "fimpara" in linha:
                novo_comando = pegaComando("fimpara")
                conteudo_arquivo.append(novo_comando)
                #print('fimpara')
            
            elif "var " in linha:
                linha2 = linha.split(":")
                nome_variavel = linha2[0][3:].strip()
                tipo_variavel = linha2[1].strip()
                #print (nome_variavel)
                #print (tipo_variavel)
                if tipo_variavel == "inteiro":
                    variables[nome_variavel] = "int"
                elif tipo_variavel == "real":
                    variables[nome_variavel] = "float"
                elif tipo_variavel == "caractere":
                    variables[nome_variavel] = ""

            elif "leia" in linha.split():
                try:
                    variavel = linha[linha.find("(")+1:linha.find(")")]
                    linha = variavel + " = " +variables[variavel]+ "(input())\n"
                except IndexError:
                    print ('variavel nao existe')
                conteudo_arquivo.append(linha)
                #final.write(linha)
                
                #x = float(input("Enter a number:"))
                #print (variavel)
                #linha2 = linha.split(":")
                #nome_variavel = linha2[0][3:].strip()
                #tipo_variavel = linha2[1].strip()
                #print (nome_variavel)
                #variables[nome_variavel] = tipo_variavel

            elif "escreva" in linha.split():
                index_inicio_parenteses = linha.find("(")
                index_fim_parenteses = linha.find(")")
                argumento = linha[index_inicio_parenteses+1:index_fim_parenteses]
                linha2 = argumento.split("+")
                #print(linha2)
                linha_nova = ""
                i = 0
                tamanho = len(linha2)

                while i < tamanho:
                    linha3 = linha2[i]
                    if linha2[i].strip().startswith('"') and not (linha2[i].strip().endswith('"')):
                        #print('entrou')
                        linha3 = linha2[i] + linha2[i+1]
                        i = i+2
                    #print (linha2[i])
                    linha_nova += "str("+ linha3 +") + "
                    i = i+1
                linha_nova = linha_nova[:-3]
                argumento = linha_nova
                command = linha[0:index_inicio_parenteses].strip()
                tmp = command.split(" ")
                command_parts = linha.replace(argumento, "").replace("(", "").replace(")","").strip().split(" ")
                novo_comando = pegaComando("escreva")
                linha_nova = novo_comando + "(" + argumento + ")\n"
                conteudo_arquivo.append(linha_nova)
                #final.write(linha_nova)

            elif "para" in linha:
                tmp = linha.split(" ")
                #print (tmp)
                increment = "1"
                step_index = linha.find("passo")
                if step_index > 0:
                    increment = tmp[7]

                novo_comando = pegaComando("para")
                #print(tmp)
                linha_nova = novo_comando + " " + tmp[1] + " in range(" + tmp[3] + ", + "+tmp[5]+" + 1, " + increment + "):\n"
                #print (linha_nova)
                #linha_nova = "for " + tmp[1] + " in range(" + tmp[3] + ", + "+tmp[5]+" + 1, " + increment + "):\n"
                conteudo_arquivo.append(linha_nova)
                #final.write(linha_nova)
                

#            elif "enquanto" in linha:
#                tmp = linha.split(" ")
#                #print (tmp)
#                increment = "1"
#                step_index = linha.find("passo")
#                if step_index > 0:
#                    increment = tmp[7]
#
#                novo_comando = pegaComando("para")
#                linha_nova = novo_comando + " " + tmp[1] + " in range(" + tmp[3] + ", + "+tmp[5]+" + 1, " + increment + "):\n"
#                #linha_nova = "for " + tmp[1] + " in range(" + tmp[3] + ", + "+tmp[5]+" + 1, " + increment + "):\n"
#                final.write(linha_nova)

            else:
                for (velho, novo) in dicionario:
                    linha = linha.replace(velho, novo)
                    #linha = re.sub(r"\b"+velho+r"\b", novo, linha)
                conteudo_arquivo.append(linha)
                #final.write(linha)
            #print (linha)
        #print (variables['n1'])
        #print (variables['n2'])
        codigo_indentado = indenta(conteudo_arquivo)
        for linha_nova in codigo_indentado:
            final.write(linha_nova)
        final.close()  

def indenta(file_content):
    current_tabs = 0
    content = []
    i = 1
    #content.append(set_charset())
    increment_indent = 0
    for line in file_content:
        command = line.strip()

        if command.startswith("#end"):
            tmp = command.split("\n")
            
            if len(tmp) == 2:
                content.append("\t" * (current_tabs-1) + tmp[1] + "\n" + "\t" * (current_tabs-1) + tmp[0] + "\n")
                current_tabs-=1
                if tmp[1].endswith(":"):
                     current_tabs+= 1
                continue

            increment_indent = -1
        elif command.endswith(":"):
            increment_indent = 1

        content.append("\t" * current_tabs + line.strip() + "\n")
        current_tabs+= increment_indent
        
        if current_tabs < 0:
            current_tabs = 0

        increment_indent = 0
        i+=1
    return content




main()