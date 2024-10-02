# Sistrans - Funcionalidades

## 1. **Gerenciamento de Clientes**
O Sistrans permite o gerenciamento completo de clientes através das seguintes funcionalidades:

- **Listar Clientes**: 
  - Exibe uma lista de todos os clientes cadastrados.
  - Inclui tratamento de erros para falhas ao carregar a lista.

- **Criar Cliente**:
  - Oferece um formulário para cadastro de novos clientes.
  - Valida os dados inseridos, como `nome`, `cpf`, `email`, entre outros.

- **Armazenar Cliente**:
  - Salva as informações do cliente no banco de dados.
  - Permite o upload de uma foto de perfil, armazenando-a no diretório apropriado.

- **Visualizar Cliente**:
  - Mostra os detalhes de um cliente específico.
  - Inclui tratamento de exceções para clientes não encontrados.

- **Editar Cliente**:
  - Permite a edição dos dados de um cliente existente.
  - Valida as informações e permite a troca da foto de perfil, caso necessário.

- **Atualizar Cliente**:
  - Atualiza as informações do cliente no banco de dados.
  - Gerencia a exclusão da foto de perfil anterior, caso uma nova seja carregada.

- **Excluir Cliente**:
  - Remove um cliente do banco de dados.
  - Exclui a foto de perfil associada ao cliente, se existir.

## 2. **Gerenciamento de Agendamentos**
O Sistrans também oferece funcionalidades para gerenciar agendamentos:

- **Listar Agendamentos**:
  - Exibe todos os agendamentos existentes.
  - Inclui tratamento de erros para problemas ao carregar a lista.

- **Criar Agendamento**:
  - Permite o cadastro de novos agendamentos.
  - Valida os dados, como data, horário e cliente associado.

- **Visualizar Agendamento**:
  - Mostra os detalhes de um agendamento específico.
  - Implementa tratamento para agendamentos não encontrados.

- **Editar Agendamento**:
  - Facilita a edição de um agendamento existente.
  - Realiza validações necessárias antes de atualizar os dados.

- **Excluir Agendamento**:
  - Remove um agendamento do sistema.
  - Inclui tratamento de erros para agendamentos não encontrados.

## 3. **Autenticação de Usuários**
O Sistrans possui funcionalidades para gerenciar a autenticação de usuários:

- **Registrar Usuário**:
  - Permite que novos usuários se registrem no sistema.
  - Realiza validações nos dados de entrada.

- **Login de Usuário**:
  - Autentica usuários com suas credenciais.
  - Garante o acesso ao sistema para usuários registrados.

- **Logout de Usuário**:
  - Permite que os usuários se desconectem do sistema.

- **Redefinir Senha**:
  - Facilita a recuperação de senhas esquecidas.

- **Verificação de Email**:
  - Garante que os usuários confirmem seus endereços de email após o registro.

- **Autenticação de Dois Fatores**:
  - Adiciona uma camada extra de segurança, exigindo uma segunda forma de verificação ao realizar login.

## 4. **Tratamento de Erros**
- Implementação de tratamento de exceções para garantir que mensagens de erro amigáveis sejam exibidas ao usuário em caso de falhas na operação.

## 5. **Validação de Dados**
- Validação robusta dos dados inseridos pelos usuários, garantindo que campos obrigatórios sejam preenchidos e que informações como `cpf` e `email` sejam únicos no banco de dados.

## 6. **Armazenamento de Arquivos**
- Suporte para upload e gerenciamento de fotos de perfil dos clientes, garantindo que as imagens sejam armazenadas de maneira adequada e que as antigas sejam removidas quando novas forem enviadas.

## 7. **Interface de Usuário**
- Integração com o Laravel para uma interface web intuitiva, utilizando views que facilitam o cadastro, edição e visualização de clientes e agendamentos.

---

Essas funcionalidades proporcionam uma gestão eficiente de clientes e agendamentos dentro do sistema Sistrans, permitindo que os usuários realizem operações CRUD (Criar, Ler, Atualizar e Excluir) de forma eficaz e com feedback adequado.
