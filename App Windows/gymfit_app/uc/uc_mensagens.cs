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
    public partial class uc_mensagens : UserControl
    {
        public uc_mensagens()
        {
            InitializeComponent();
        }

        public void busca_mensagens(string search)
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

                Cmd = new MySqlCommand("SELECT nome_cliente, email_cliente, mensagem, data_envio, respondida FROM mensagens" + search, Conn);

                Dr = Cmd.ExecuteReader();

                while (Dr.Read())
                {
                    dgv_mensagens.Rows.Add(Dr[0].ToString(), Dr[1].ToString(), Dr[2].ToString(), Dr[3].ToString(), Dr[4].ToString());
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

        private void uc_mensagens_Load(object sender, EventArgs e)
        {
            busca_mensagens("");
        }

        private void pic_refresh_Click(object sender, EventArgs e)
        {
            dgv_mensagens.Rows.Clear();
            busca_mensagens("");
        }

        private void btn_search_Click(object sender, EventArgs e)
        {
            string searchBox = txt_search.Text;

            if(searchBox != "")
            {
                string search_string = "WHERE nome_cliente = '" + searchBox + "' OR email_cliente = '" + searchBox + "' OR mensagem LIKE '%" + searchBox + "%'";
                busca_mensagens(search_string);
            }
            else
            {
                busca_mensagens("");
            }
        }
    }
}
