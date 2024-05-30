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
    public partial class uc_dashboard : UserControl
    {
        public uc_dashboard()
        {
            InitializeComponent();
        }

        public void carregaDados()
        {
            MySqlConnection Conn;
            MySqlCommand Cmd;
            MySqlDataReader Dr;

            Conn = new MySqlConnection(config.conn_string);


            /* ====================================================================
             * CONTA O NUMERO DE CLIENTES
             * ====================================================================
             */
            try
            {
                Conn.Open();

                Cmd = new MySqlCommand("SELECT COUNT(*) AS TOTAL FROM utilizadores", Conn);

                Dr = Cmd.ExecuteReader();

                if (Dr.Read())
                {
                    lb_totalClients.Text = Dr["TOTAL"].ToString();
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


            /* ====================================================================
             * CONTA O NUMERO DE CLIENTES QUE CONTENHAM UMA MENSALIDADE SELECIONADA
             * ====================================================================
             */
            try
            {
                Conn.Open();

                Cmd = new MySqlCommand("SELECT COUNT(*) AS TOTAL FROM mensalidades_aquisicoes WHERE mensalidade <> 1", Conn);

                Dr = Cmd.ExecuteReader();

                if (Dr.Read())
                {
                    lb_activeClients.Text = Dr["TOTAL"].ToString();
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

            /* ====================================================================
             * BUSCA MENSAGENS
             * ====================================================================
             */
            try
            {
                Conn.Open();

                Cmd = new MySqlCommand("SELECT nome_cliente, mensagem FROM mensagens WHERE respondida NOT LIKE 's' AND vista NOT LIKE 's'", Conn);

                Dr = Cmd.ExecuteReader();

                while (Dr.Read())
                {
                    dgv_mensagens.Rows.Add(Dr[0].ToString(), Dr[1].ToString());
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

        private void uc_dashboard_Load(object sender, EventArgs e)
        {
            carregaDados();
        }

        private void pic_refresh_Click(object sender, EventArgs e)
        {
            dgv_mensagens.Rows.Clear();
            lb_activeClients.Text = "";
            lb_totalClients.Text = "";
            carregaDados();
        }
    }
}
