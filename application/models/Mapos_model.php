<?php
class Mapos_model extends CI_Model
{

    /**
     * author: Ramon Silva
     * email: silva018-mg@yahoo.com.br
     *
     */

    public function __construct()
    {
        parent::__construct();
    }

    public function get($table, $fields, $where = '', $perpage = 0, $start = 0, $one = false, $array = 'array')
    {
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->limit($perpage, $start);
        if ($where) {
            $this->db->where($where);
        }

        $query = $this->db->get();

        $result = !$one ? $query->result() : $query->row();
        return $result;
    }

    public function getById($id)
    {
        $this->db->from('usuarios');
        $this->db->select('usuarios.*, permissoes.nome as permissao');
        $this->db->join('permissoes', 'permissoes.idPermissao = usuarios.permissoes_id', 'left');
        $this->db->where('idUsuarios', $id);
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    public function alterarSenha($senha)
    {
        $this->db->set('senha', password_hash($senha, PASSWORD_DEFAULT));
        $this->db->where('idUsuarios', $this->session->userdata('id'));
        $this->db->update('usuarios');

        if ($this->db->affected_rows() >= 0) {
            return true;
        }
        return false;
    }

    public function pesquisar($termo)
    {
        $data = [];
        // buscando clientes
        $this->db->like('nomeCliente', $termo);
        $this->db->or_like('telefone', $termo);
        $this->db->or_like('celular', $termo);
        $this->db->limit($this->data['configuration']['per_page']);
        $data['clientes'] = $this->db->get('clientes')->result();

        // buscando os
        $this->db->like('idOs', $termo);
        $this->db->or_like('descricaoProduto', $termo);
        $this->db->or_like('serial', $termo);
        $this->db->limit($this->data['configuration']['per_page']);
        $data['os'] = $this->db->get('os')->result();

        // buscando produtos
        $this->db->like('codDeBarra', $termo);
        $this->db->or_like('idProdutos', $termo);
        $this->db->or_like('descricao', $termo);
        $this->db->limit($this->data['configuration']['per_page']);
        $data['produtos'] = $this->db->get('produtos')->result();

        //buscando serviços
        $this->db->like('nome', $termo);
        $this->db->limit($this->data['configuration']['per_page']);
        $data['servicos'] = $this->db->get('servicos')->result();

        return $data;
    }

    public function add($table, $data)
    {
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() == '1') {
            return true;
        }

        return false;
    }

    public function edit($table, $data, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0) {
            return true;
        }

        return false;
    }

    public function delete($table, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1') {
            return true;
        }

        return false;
    }

    public function count($table)
    {
        return $this->db->count_all($table);
    }

		public function getOsOrcamento()
    {
		$this->db->select('os.*,
		COALESCE((SELECT SUM(produtos_os.preco * produtos_os.quantidade ) FROM produtos_os WHERE produtos_os.os_id = os.idOs), 0) totalProdutos,
		COALESCE((SELECT SUM(servicos_os.preco * servicos_os.quantidade ) FROM servicos_os WHERE servicos_os.os_id = os.idOs), 0) totalServicos');
		$this->db->select('os.*, clientes.nomeCliente');
		$this->db->select('os.*, clientes.telefone');
		$this->db->select('os.*, clientes.senha as senha_cliente');
		$this->db->select('os.*, clientes.email as email_cliemte');
		$this->db->from('os');
		$this->db->join('clientes', 'clientes.idClientes = os.clientes_id', 'emitente', 'emitente.telefone');
		$this->db->where('os.status', 'Orçamento');
		$this->db->limit($this->data['configuration']['per_page']);
		$this->db->order_by('idOs', 'desc');
				return $this->db->get()->result();
    }

    public function getOsOrcamentoConcluido()
    {
		$this->db->select('os.*,
		COALESCE((SELECT SUM(produtos_os.preco * produtos_os.quantidade ) FROM produtos_os WHERE produtos_os.os_id = os.idOs), 0) totalProdutos,
		COALESCE((SELECT SUM(servicos_os.preco * servicos_os.quantidade ) FROM servicos_os WHERE servicos_os.os_id = os.idOs), 0) totalServicos');
		$this->db->select('os.*, clientes.nomeCliente');
		$this->db->select('os.*, clientes.telefone');
		$this->db->select('os.*, clientes.senha as senha_cliente');
		$this->db->select('os.*, clientes.email as email_cliemte');
		$this->db->from('os');
		$this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
 		$this->db->where('os.status', 'Orçamento Concluido');
		$this->db->limit($this->data['configuration']['per_page']);
		$this->db->order_by('idOs', 'desc');
				return $this->db->get()->result();
    }

    public function getOsOrcamentoAprovado()
    {
		$this->db->select('os.*,
		COALESCE((SELECT SUM(produtos_os.preco * produtos_os.quantidade ) FROM produtos_os WHERE produtos_os.os_id = os.idOs), 0) totalProdutos,
		COALESCE((SELECT SUM(servicos_os.preco * servicos_os.quantidade ) FROM servicos_os WHERE servicos_os.os_id = os.idOs), 0) totalServicos');
		$this->db->select('os.*, clientes.nomeCliente');
		$this->db->select('os.*, clientes.telefone');
		$this->db->select('os.*, clientes.senha as senha_cliente');
		$this->db->select('os.*, clientes.email as email_cliemte');
		$this->db->from('os');
		$this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
		$this->db->where('os.status', 'Orçamento Aprovado');
		$this->db->limit($this->data['configuration']['per_page']);
		$this->db->order_by('idOs', 'desc');
				return $this->db->get()->result();
    }

    public function getOsEmAndamento()
    {
		$this->db->select('os.*,
		COALESCE((SELECT SUM(produtos_os.preco * produtos_os.quantidade ) FROM produtos_os WHERE produtos_os.os_id = os.idOs), 0) totalProdutos,
		COALESCE((SELECT SUM(servicos_os.preco * servicos_os.quantidade ) FROM servicos_os WHERE servicos_os.os_id = os.idOs), 0) totalServicos');
		$this->db->select('os.*, clientes.nomeCliente');
		$this->db->select('os.*, clientes.telefone');
		$this->db->select('os.*, clientes.senha as senha_cliente');
		$this->db->select('os.*, clientes.email as email_cliemte');
		$this->db->from('os');
		$this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
		$this->db->where('os.status', 'Em Andamento');
		$this->db->limit($this->data['configuration']['per_page']);
		$this->db->order_by('idOs', 'desc');
				return $this->db->get()->result();
    }

    public function getOsAguardandoPecas()
    {
		$this->db->select('os.*,
		COALESCE((SELECT SUM(produtos_os.preco * produtos_os.quantidade ) FROM produtos_os WHERE produtos_os.os_id = os.idOs), 0) totalProdutos,
		COALESCE((SELECT SUM(servicos_os.preco * servicos_os.quantidade ) FROM servicos_os WHERE servicos_os.os_id = os.idOs), 0) totalServicos');
		$this->db->select('os.*, clientes.nomeCliente');
		$this->db->select('os.*, clientes.telefone');
		$this->db->select('os.*, clientes.senha as senha_cliente');
		$this->db->select('os.*, clientes.email as email_cliemte');
		$this->db->from('os');
		$this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
		$this->db->where('os.status', 'Aguardando Peças');
		$this->db->limit($this->data['configuration']['per_page']);
		$this->db->order_by('idOs', 'desc');
				return $this->db->get()->result();
    }

    public function getOsConcluido()
    {
		$this->db->select('
		COALESCE((SELECT SUM(produtos_os.preco * produtos_os.quantidade ) FROM produtos_os WHERE produtos_os.os_id = os.idOs), 0) totalProdutos,
		COALESCE((SELECT SUM(servicos_os.preco * servicos_os.quantidade ) FROM servicos_os WHERE servicos_os.os_id = os.idOs), 0) totalServicos');
		$this->db->select('os.*, clientes.nomeCliente');
		$this->db->select('os.*, clientes.telefone');
		$this->db->select('os.*, clientes.senha as senha_cliente');
		$this->db->select('os.*, clientes.email as email_cliemte');
		$this->db->from('os');
		$this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
		$this->db->where('os.status', 'Serviço Concluido');
		$this->db->limit($this->data['configuration']['per_page']);
		$this->db->order_by('idOs', 'desc');
				return $this->db->get()->result();
    }

    public function getOsEntregueAReceber()
    {
		$this->db->select('os.*,
		COALESCE((SELECT SUM(produtos_os.preco * produtos_os.quantidade ) FROM produtos_os WHERE produtos_os.os_id = os.idOs), 0) totalProdutos,
		COALESCE((SELECT SUM(servicos_os.preco * servicos_os.quantidade ) FROM servicos_os WHERE servicos_os.os_id = os.idOs), 0) totalServicos');
		$this->db->select('os.*, clientes.nomeCliente');
		$this->db->select('os.*, clientes.telefone');
		$this->db->select('os.*, clientes.senha as senha_cliente');
		$this->db->select('os.*, clientes.email as email_cliemte');
		$this->db->from('os');
		$this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
		$this->db->where('os.status', 'Entregue - A Receber');
		$this->db->limit($this->data['configuration']['per_page']);
		$this->db->order_by('idOs', 'desc');
				return $this->db->get()->result();
    }
	
	public function calendario($start, $end, $status = null)
    {
        $this->db->select(
            'os.*,
            clientes.nomeCliente,
		COALESCE((SELECT SUM(produtos_os.preco * produtos_os.quantidade ) FROM produtos_os WHERE produtos_os.os_id = os.idOs), 0) totalProdutos,
		COALESCE((SELECT SUM(servicos_os.preco * servicos_os.quantidade ) FROM servicos_os WHERE servicos_os.os_id = os.idOs), 0) totalServicos'
        );
        $this->db->from('os');
        $this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
        $this->db->join('produtos_os', 'produtos_os.os_id = os.idOs', 'left');
        $this->db->join('servicos_os', 'servicos_os.os_id = os.idOs', 'left');
        $this->db->where('os.dataFinal >=', $start);
        $this->db->where('os.dataFinal <=', $end);
        $this->db->group_by('os.idOs');

        if (!empty($status)) {
            $this->db->where('os.status', $status);
        }

        return $this->db->get()->result();
    }

    public function getProdutosMinimo()
    {
        $sql = "SELECT * FROM produtos WHERE estoque <= estoqueMinimo AND estoqueMinimo > 0 LIMIT 10";
        return $this->db->query($sql)->result();
    }

    public function getOsEstatisticas()
    {
        $sql = "SELECT status, COUNT(status) as total FROM os GROUP BY status ORDER BY status";
        return $this->db->query($sql)->result();
    }

    public function getEstatisticasFinanceiro()
    {
        $sql = "SELECT SUM(CASE WHEN baixado = 1 AND tipo = 'receita' THEN valor END) as total_receita,
                       SUM(CASE WHEN baixado = 1 AND tipo = 'despesa' THEN valor END) as total_despesa,
                       SUM(CASE WHEN baixado = 0 AND tipo = 'receita' THEN valor END) as total_receita_pendente,
                       SUM(CASE WHEN baixado = 0 AND tipo = 'despesa' THEN valor END) as total_despesa_pendente FROM lancamentos";

        return $this->db->query($sql)->row();
    }

    public function getEstatisticasFinanceiroMes($year)
    {
        $numbersOnly = preg_replace('/[^0-9]/', '', $year);

        if (!$numbersOnly) {
            $numbersOnly = date('Y');
        }

        $sql = "
            SELECT
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 1) AND baixado = 1 AND tipo = 'receita' THEN valor END) AS VALOR_JAN_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 1) AND baixado = 1 AND tipo = 'despesa' THEN valor END) AS VALOR_JAN_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 2) AND baixado = 1 AND tipo = 'receita' THEN valor END) AS VALOR_FEV_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 2) AND baixado = 1 AND tipo = 'despesa' THEN valor END) AS VALOR_FEV_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 3) AND baixado = 1 AND tipo = 'receita' THEN valor END) AS VALOR_MAR_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 3) AND baixado = 1 AND tipo = 'despesa' THEN valor END) AS VALOR_MAR_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 4) AND baixado = 1 AND tipo = 'receita' THEN valor END) AS VALOR_ABR_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 4) AND baixado = 1 AND tipo = 'despesa' THEN valor END) AS VALOR_ABR_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 5) AND baixado = 1 AND tipo = 'receita' THEN valor END) AS VALOR_MAI_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 5) AND baixado = 1 AND tipo = 'despesa' THEN valor END) AS VALOR_MAI_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 6) AND baixado = 1 AND tipo = 'receita' THEN valor END) AS VALOR_JUN_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 6) AND baixado = 1 AND tipo = 'despesa' THEN valor END) AS VALOR_JUN_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 7) AND baixado = 1 AND tipo = 'receita' THEN valor END) AS VALOR_JUL_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 7) AND baixado = 1 AND tipo = 'despesa' THEN valor END) AS VALOR_JUL_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 8) AND baixado = 1 AND tipo = 'receita' THEN valor END) AS VALOR_AGO_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 8) AND baixado = 1 AND tipo = 'despesa' THEN valor END) AS VALOR_AGO_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 9) AND baixado = 1 AND tipo = 'receita' THEN valor END) AS VALOR_SET_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 9) AND baixado = 1 AND tipo = 'despesa' THEN valor END) AS VALOR_SET_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 10) AND baixado = 1 AND tipo = 'receita' THEN valor END) AS VALOR_OUT_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 10) AND baixado = 1 AND tipo = 'despesa' THEN valor END) AS VALOR_OUT_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 11) AND baixado = 1 AND tipo = 'receita' THEN valor END) AS VALOR_NOV_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 11) AND baixado = 1 AND tipo = 'despesa' THEN valor END) AS VALOR_NOV_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 12) AND baixado = 1 AND tipo = 'receita' THEN valor END) AS VALOR_DEZ_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 12) AND baixado = 1 AND tipo = 'despesa' THEN valor END) AS VALOR_DEZ_DES
            FROM lancamentos
            WHERE EXTRACT(YEAR FROM data_pagamento) = ?
        ";

        return $this->db->query($sql, [intval($numbersOnly)])->row();
    }

    public function getEstatisticasFinanceiroMesInadimplencia($year)
    {
        $numbersOnly = preg_replace('/[^0-9]/', '', $year);

        if (!$numbersOnly) {
            $numbersOnly = date('Y');
        }

        $sql = "
            SELECT
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 1) AND baixado = 0 AND tipo = 'receita' THEN valor END) AS VALOR_JAN_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 1) AND baixado = 0 AND tipo = 'despesa' THEN valor END) AS VALOR_JAN_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 2) AND baixado = 0 AND tipo = 'receita' THEN valor END) AS VALOR_FEV_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 2) AND baixado = 0 AND tipo = 'despesa' THEN valor END) AS VALOR_FEV_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 3) AND baixado = 0 AND tipo = 'receita' THEN valor END) AS VALOR_MAR_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 3) AND baixado = 0 AND tipo = 'despesa' THEN valor END) AS VALOR_MAR_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 4) AND baixado = 0 AND tipo = 'receita' THEN valor END) AS VALOR_ABR_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 4) AND baixado = 0 AND tipo = 'despesa' THEN valor END) AS VALOR_ABR_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 5) AND baixado = 0 AND tipo = 'receita' THEN valor END) AS VALOR_MAI_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 5) AND baixado = 0 AND tipo = 'despesa' THEN valor END) AS VALOR_MAI_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 6) AND baixado = 0 AND tipo = 'receita' THEN valor END) AS VALOR_JUN_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 6) AND baixado = 0 AND tipo = 'despesa' THEN valor END) AS VALOR_JUN_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 7) AND baixado = 0 AND tipo = 'receita' THEN valor END) AS VALOR_JUL_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 7) AND baixado = 0 AND tipo = 'despesa' THEN valor END) AS VALOR_JUL_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 8) AND baixado = 0 AND tipo = 'receita' THEN valor END) AS VALOR_AGO_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 8) AND baixado = 0 AND tipo = 'despesa' THEN valor END) AS VALOR_AGO_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 9) AND baixado = 0 AND tipo = 'receita' THEN valor END) AS VALOR_SET_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 9) AND baixado = 0 AND tipo = 'despesa' THEN valor END) AS VALOR_SET_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 10) AND baixado = 0 AND tipo = 'receita' THEN valor END) AS VALOR_OUT_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 10) AND baixado = 0 AND tipo = 'despesa' THEN valor END) AS VALOR_OUT_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 11) AND baixado = 0 AND tipo = 'receita' THEN valor END) AS VALOR_NOV_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 11) AND baixado = 0 AND tipo = 'despesa' THEN valor END) AS VALOR_NOV_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 12) AND baixado = 0 AND tipo = 'receita' THEN valor END) AS VALOR_DEZ_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 12) AND baixado = 0 AND tipo = 'despesa' THEN valor END) AS VALOR_DEZ_DES
            FROM lancamentos
            WHERE EXTRACT(YEAR FROM data_pagamento) = ?
        ";

        return $this->db->query($sql, [intval($numbersOnly)])->row();
    }

    public function getTermo()
    {
        return $this->db->get('configuracoes')->result();
    }

    public function getEmitente()
    {
        return $this->db->get('emitente')->result();
    }

    public function addEmitente($nome, $cnpj, $ie, $cep, $logradouro, $numero, $bairro, $cidade, $uf, $telefone, $email, $logo)
    {
        $this->db->set('nome', $nome);
        $this->db->set('cnpj', $cnpj);
        $this->db->set('ie', $ie);
        $this->db->set('cep', $cep);
        $this->db->set('rua', $logradouro);
        $this->db->set('numero', $numero);
        $this->db->set('bairro', $bairro);
        $this->db->set('cidade', $cidade);
        $this->db->set('uf', $uf);
        $this->db->set('telefone', $telefone);
        $this->db->set('email', $email);
        $this->db->set('url_logo', $logo);
        return $this->db->insert('emitente');
    }

    public function editEmitente($id, $nome, $cnpj, $ie, $cep, $logradouro, $numero, $bairro, $cidade, $uf, $telefone, $email)
    {
        $this->db->set('nome', $nome);
        $this->db->set('cnpj', $cnpj);
        $this->db->set('ie', $ie);
        $this->db->set('cep', $cep);
        $this->db->set('rua', $logradouro);
        $this->db->set('numero', $numero);
        $this->db->set('bairro', $bairro);
        $this->db->set('cidade', $cidade);
        $this->db->set('uf', $uf);
        $this->db->set('telefone', $telefone);
        $this->db->set('email', $email);
        $this->db->where('id', $id);
        return $this->db->update('emitente');
    }

    public function editLogo($id, $logo)
    {
        $this->db->set('url_logo', $logo);
        $this->db->where('id', $id);
        return $this->db->update('emitente');
    }

    public function check_credentials($email)
    {
        $this->db->where('email', $email);
        $this->db->where('situacao', 1);
        $this->db->limit(1);
        return $this->db->get('usuarios')->row();
    }

    /**
     * Salvar configurações do sistema
     * @param array $data
     * @return boolean
     */
    public function editLogoTermica($id, $logotermica)
    {
        $this->db->set('url_termica', $logotermica);
        $this->db->where('id', $id);
        return $this->db->update('emitente');
    }

    public function saveConfiguracao($data)
    {
        try {
            foreach ($data as $key => $valor) {
                $this->db->set('valor', $valor);
                $this->db->where('config', $key);
                $this->db->update('configuracoes');
            }
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
}
