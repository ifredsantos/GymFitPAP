using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace gymfit_app
{
    public partial class MainForm : Form
    {
        public MainForm()
        {
            InitializeComponent();
        }
		/*
         * Tamanho de user control -> 792; 511
         * Localização ->207; 86
         * Background Color: 15; 15; 15
         */

		private void MainForm_Load(object sender, EventArgs e)
        {
			if (config.utilizador.username != "")
			{
				lb_username.Text = config.utilizador.username;
				pic_status_on.Visible = true;
				pic_status_off.Visible = false;
            }
			else
			{
				lb_username.Text = "Desconhecido";
				pic_status_on.Visible = false;
				pic_status_off.Visible = true;
                Enabled = false;
            }
            panel_selectedMenu.Height = btn_dashboard.Height;
            uc_dashboard1.BringToFront();
            lb_action.Text = "Painel de controlo";
        }

		private void btn_power_Click(object sender, EventArgs e)
		{
			config.utilizador.username = "";
			config.utilizador.tipo_user = "";
			Dispose();
			FormLogin frmLogin = new FormLogin();
			frmLogin.Show();
		}

		private void btn_settings_Click(object sender, EventArgs e)
		{

		}

		private void pic_close_Click(object sender, EventArgs e)
		{
			Application.Exit();
		}

		private void pic_min_Click(object sender, EventArgs e)
		{
			this.WindowState = FormWindowState.Minimized;
		}

        private void btn_dashboard_Click(object sender, EventArgs e)
        {
            panel_selectedMenu.Height = btn_dashboard.Height;
            panel_selectedMenu.Top = btn_dashboard.Top;
            uc_dashboard1.BringToFront();
            lb_action.Text = "Painel de controlo";
        }

        private void btn_messages_Click(object sender, EventArgs e)
        {
            panel_selectedMenu.Height = btn_messages.Height;
            panel_selectedMenu.Top = btn_messages.Top;
            uc_mensagens1.BringToFront();
            lb_action.Text = "Mensagens";
        }

        private void btn_products_Click(object sender, EventArgs e)
        {
            panel_selectedMenu.Height = btn_products.Height;
            panel_selectedMenu.Top = btn_products.Top;
            uc_produtos1.BringToFront();
            lb_action.Text = "Produtos";
        }

		private void btn_montly_Click(object sender, EventArgs e)
		{
			panel_selectedMenu.Height = btn_montly.Height;
			panel_selectedMenu.Top = btn_montly.Top;
			uc_mensalidades1.BringToFront();
			lb_action.Text = "Mensalidades";
		}
	}
}
