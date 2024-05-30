using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Drawing;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using MySql.Data.MySqlClient;

namespace gymfit_app
{
    public partial class uc_produtos : UserControl
    {
        public uc_produtos()
        {
            InitializeComponent();
        }

        public void busca_produtos(string search)
        {
            MySqlConnection Conn;
            MySqlCommand Cmd;
            MySqlDataReader Dr;

            Conn = new MySqlConnection(config.conn_string);

            /* ====================================================================
             * BUSCA MENSAGENS
             * ====================================================================
             */
            try
            {
                Conn.Open();

                Cmd = new MySqlCommand("SELECT P.ref, P.nome_produto, P.descricao_produto, P.stock, PM.nome_marca, PC.nome_categoria, P.preco_fornecedor, P.PVP, P.sabor, P.tamanho, P.cor, P.peso, P.desconto, P.fotos, P.visitas, P.vendido " + 
                    "FROM produtos P " +
                        "INNER JOIN produtos_marcas PM ON P.cod_marca = PM.cod_marca " +
                        "INNER JOIN produtos_categorias PC ON P.cod_categoria = PC.cod_categoria " +
                    "ORDER BY nome_produto"
                    + search, Conn);

                Dr = Cmd.ExecuteReader();

                while (Dr.Read())
                {
                    dgv_products.Rows.Add(
						Dr[0].ToString(), 
						Dr[1].ToString(), 
						Dr[2].ToString(), 
						Dr[3].ToString(), 
						Dr[4].ToString(), 
						Dr[5].ToString(), 
						Dr[6]+"€".ToString(), 
						Dr[7] + "€".ToString(), 
						Dr[8].ToString(), 
						Dr[9].ToString(), 
						Dr[10].ToString(), 
						Dr[11] + "%".ToString(), 
						Dr[12] + "g".ToString(), 
						Dr[13].ToString(), 
						Dr[14].ToString(), 
						Dr[15].ToString()
					);
                }
            }
            catch (MySqlException Sql)
            {
                throw Sql;
            }
            finally
            {
                if (Conn.State == ConnectionState.Open)
                {
                    Conn.Close();
                }

                Conn.Dispose();
            }
        }

        private void uc_produtos_Load(object sender, EventArgs e)
        {
            busca_produtos("");
        }

		private void pic_refresh_Click(object sender, EventArgs e)
		{
			dgv_products.Rows.Clear();
			busca_produtos("");
			MessageBox.Show("Produtos atualizados com sucesso", "Atualizado", MessageBoxButtons.OK, MessageBoxIcon.Asterisk);
		}
	}
}
