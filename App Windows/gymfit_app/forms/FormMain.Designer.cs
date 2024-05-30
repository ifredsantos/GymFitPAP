namespace gymfit_app
{
    partial class MainForm
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
			System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(MainForm));
			this.panel1 = new System.Windows.Forms.Panel();
			this.panel_selectedMenu = new System.Windows.Forms.Panel();
			this.btn_products = new System.Windows.Forms.Button();
			this.pic_status_on = new System.Windows.Forms.PictureBox();
			this.panel4 = new System.Windows.Forms.Panel();
			this.panel3 = new System.Windows.Forms.Panel();
			this.lb_username = new System.Windows.Forms.Label();
			this.pic_status_off = new System.Windows.Forms.PictureBox();
			this.btn_power = new System.Windows.Forms.Button();
			this.btn_settings = new System.Windows.Forms.Button();
			this.btn_messages = new System.Windows.Forms.Button();
			this.btn_montly = new System.Windows.Forms.Button();
			this.btn_clients = new System.Windows.Forms.Button();
			this.btn_delivery = new System.Windows.Forms.Button();
			this.label1 = new System.Windows.Forms.Label();
			this.btn_dashboard = new System.Windows.Forms.Button();
			this.lb_action = new System.Windows.Forms.Label();
			this.panel5 = new System.Windows.Forms.Panel();
			this.panel2 = new System.Windows.Forms.Panel();
			this.panel_move = new System.Windows.Forms.Panel();
			this.pic_min = new System.Windows.Forms.PictureBox();
			this.pic_close = new System.Windows.Forms.PictureBox();
			this.uc_mensalidades1 = new gymfit_app.uc.uc_mensalidades();
			this.uc_dashboard1 = new gymfit_app.uc_dashboard();
			this.uc_produtos1 = new gymfit_app.uc_produtos();
			this.uc_mensagens1 = new gymfit_app.uc_mensagens();
			this.cl_dragControl1 = new gymfit_app.cl_dragControl();
			this.panel1.SuspendLayout();
			((System.ComponentModel.ISupportInitialize)(this.pic_status_on)).BeginInit();
			((System.ComponentModel.ISupportInitialize)(this.pic_status_off)).BeginInit();
			((System.ComponentModel.ISupportInitialize)(this.pic_min)).BeginInit();
			((System.ComponentModel.ISupportInitialize)(this.pic_close)).BeginInit();
			this.SuspendLayout();
			// 
			// panel1
			// 
			this.panel1.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			this.panel1.Controls.Add(this.panel_selectedMenu);
			this.panel1.Controls.Add(this.btn_products);
			this.panel1.Controls.Add(this.pic_status_on);
			this.panel1.Controls.Add(this.panel4);
			this.panel1.Controls.Add(this.panel3);
			this.panel1.Controls.Add(this.lb_username);
			this.panel1.Controls.Add(this.pic_status_off);
			this.panel1.Controls.Add(this.btn_power);
			this.panel1.Controls.Add(this.btn_settings);
			this.panel1.Controls.Add(this.btn_messages);
			this.panel1.Controls.Add(this.btn_montly);
			this.panel1.Controls.Add(this.btn_clients);
			this.panel1.Controls.Add(this.btn_delivery);
			this.panel1.Controls.Add(this.label1);
			this.panel1.Controls.Add(this.btn_dashboard);
			this.panel1.Dock = System.Windows.Forms.DockStyle.Left;
			this.panel1.Location = new System.Drawing.Point(0, 0);
			this.panel1.Name = "panel1";
			this.panel1.Size = new System.Drawing.Size(200, 600);
			this.panel1.TabIndex = 0;
			// 
			// panel_selectedMenu
			// 
			this.panel_selectedMenu.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(234)))), ((int)(((byte)(166)))), ((int)(((byte)(57)))));
			this.panel_selectedMenu.Location = new System.Drawing.Point(0, 59);
			this.panel_selectedMenu.Name = "panel_selectedMenu";
			this.panel_selectedMenu.Size = new System.Drawing.Size(5, 49);
			this.panel_selectedMenu.TabIndex = 2;
			// 
			// btn_products
			// 
			this.btn_products.Cursor = System.Windows.Forms.Cursors.Hand;
			this.btn_products.FlatAppearance.BorderSize = 0;
			this.btn_products.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
			this.btn_products.Font = new System.Drawing.Font("Century Gothic", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			this.btn_products.ForeColor = System.Drawing.Color.White;
			this.btn_products.Location = new System.Drawing.Point(3, 334);
			this.btn_products.Name = "btn_products";
			this.btn_products.Padding = new System.Windows.Forms.Padding(0, 0, 5, 0);
			this.btn_products.Size = new System.Drawing.Size(194, 49);
			this.btn_products.TabIndex = 8;
			this.btn_products.Text = "Produtos";
			this.btn_products.TextAlign = System.Drawing.ContentAlignment.MiddleRight;
			this.btn_products.UseVisualStyleBackColor = true;
			this.btn_products.Click += new System.EventHandler(this.btn_products_Click);
			// 
			// pic_status_on
			// 
			this.pic_status_on.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)));
			this.pic_status_on.Image = global::gymfit_app.Properties.Resources.on_point;
			this.pic_status_on.Location = new System.Drawing.Point(11, 501);
			this.pic_status_on.Name = "pic_status_on";
			this.pic_status_on.Size = new System.Drawing.Size(29, 28);
			this.pic_status_on.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom;
			this.pic_status_on.TabIndex = 7;
			this.pic_status_on.TabStop = false;
			this.pic_status_on.Visible = false;
			// 
			// panel4
			// 
			this.panel4.Anchor = System.Windows.Forms.AnchorStyles.Bottom;
			this.panel4.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(25)))), ((int)(((byte)(25)))), ((int)(((byte)(25)))));
			this.panel4.Location = new System.Drawing.Point(0, 489);
			this.panel4.Name = "panel4";
			this.panel4.Size = new System.Drawing.Size(200, 5);
			this.panel4.TabIndex = 3;
			// 
			// panel3
			// 
			this.panel3.Anchor = System.Windows.Forms.AnchorStyles.Bottom;
			this.panel3.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(25)))), ((int)(((byte)(25)))), ((int)(((byte)(25)))));
			this.panel3.Location = new System.Drawing.Point(0, 534);
			this.panel3.Name = "panel3";
			this.panel3.Size = new System.Drawing.Size(200, 5);
			this.panel3.TabIndex = 2;
			// 
			// lb_username
			// 
			this.lb_username.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)));
			this.lb_username.Font = new System.Drawing.Font("Century Gothic", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			this.lb_username.ForeColor = System.Drawing.Color.White;
			this.lb_username.Location = new System.Drawing.Point(43, 502);
			this.lb_username.Name = "lb_username";
			this.lb_username.Size = new System.Drawing.Size(154, 23);
			this.lb_username.TabIndex = 2;
			this.lb_username.Text = "Desconhecido";
			this.lb_username.TextAlign = System.Drawing.ContentAlignment.MiddleLeft;
			// 
			// pic_status_off
			// 
			this.pic_status_off.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)));
			this.pic_status_off.Image = global::gymfit_app.Properties.Resources.of_point;
			this.pic_status_off.Location = new System.Drawing.Point(11, 500);
			this.pic_status_off.Name = "pic_status_off";
			this.pic_status_off.Size = new System.Drawing.Size(29, 28);
			this.pic_status_off.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom;
			this.pic_status_off.TabIndex = 2;
			this.pic_status_off.TabStop = false;
			// 
			// btn_power
			// 
			this.btn_power.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)));
			this.btn_power.Cursor = System.Windows.Forms.Cursors.Hand;
			this.btn_power.FlatAppearance.BorderSize = 0;
			this.btn_power.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
			this.btn_power.Image = global::gymfit_app.Properties.Resources.power;
			this.btn_power.Location = new System.Drawing.Point(12, 554);
			this.btn_power.Name = "btn_power";
			this.btn_power.Size = new System.Drawing.Size(33, 34);
			this.btn_power.TabIndex = 6;
			this.btn_power.UseVisualStyleBackColor = true;
			this.btn_power.Click += new System.EventHandler(this.btn_power_Click);
			// 
			// btn_settings
			// 
			this.btn_settings.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Right)));
			this.btn_settings.Cursor = System.Windows.Forms.Cursors.Hand;
			this.btn_settings.FlatAppearance.BorderSize = 0;
			this.btn_settings.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
			this.btn_settings.Image = global::gymfit_app.Properties.Resources.settings_gears;
			this.btn_settings.Location = new System.Drawing.Point(152, 554);
			this.btn_settings.Name = "btn_settings";
			this.btn_settings.Size = new System.Drawing.Size(33, 34);
			this.btn_settings.TabIndex = 2;
			this.btn_settings.UseVisualStyleBackColor = true;
			this.btn_settings.Click += new System.EventHandler(this.btn_settings_Click);
			// 
			// btn_messages
			// 
			this.btn_messages.Cursor = System.Windows.Forms.Cursors.Hand;
			this.btn_messages.FlatAppearance.BorderSize = 0;
			this.btn_messages.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
			this.btn_messages.Font = new System.Drawing.Font("Century Gothic", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			this.btn_messages.ForeColor = System.Drawing.Color.White;
			this.btn_messages.Location = new System.Drawing.Point(4, 279);
			this.btn_messages.Name = "btn_messages";
			this.btn_messages.Padding = new System.Windows.Forms.Padding(0, 0, 5, 0);
			this.btn_messages.Size = new System.Drawing.Size(194, 49);
			this.btn_messages.TabIndex = 5;
			this.btn_messages.Text = "Mensagens";
			this.btn_messages.TextAlign = System.Drawing.ContentAlignment.MiddleRight;
			this.btn_messages.UseVisualStyleBackColor = true;
			this.btn_messages.Click += new System.EventHandler(this.btn_messages_Click);
			// 
			// btn_montly
			// 
			this.btn_montly.Cursor = System.Windows.Forms.Cursors.Hand;
			this.btn_montly.FlatAppearance.BorderSize = 0;
			this.btn_montly.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
			this.btn_montly.Font = new System.Drawing.Font("Century Gothic", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			this.btn_montly.ForeColor = System.Drawing.Color.White;
			this.btn_montly.Location = new System.Drawing.Point(4, 224);
			this.btn_montly.Name = "btn_montly";
			this.btn_montly.Padding = new System.Windows.Forms.Padding(0, 0, 5, 0);
			this.btn_montly.Size = new System.Drawing.Size(194, 49);
			this.btn_montly.TabIndex = 4;
			this.btn_montly.Text = "Mensalidades";
			this.btn_montly.TextAlign = System.Drawing.ContentAlignment.MiddleRight;
			this.btn_montly.UseVisualStyleBackColor = true;
			this.btn_montly.Click += new System.EventHandler(this.btn_montly_Click);
			// 
			// btn_clients
			// 
			this.btn_clients.Cursor = System.Windows.Forms.Cursors.Hand;
			this.btn_clients.FlatAppearance.BorderSize = 0;
			this.btn_clients.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
			this.btn_clients.Font = new System.Drawing.Font("Century Gothic", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			this.btn_clients.ForeColor = System.Drawing.Color.White;
			this.btn_clients.Location = new System.Drawing.Point(4, 169);
			this.btn_clients.Name = "btn_clients";
			this.btn_clients.Padding = new System.Windows.Forms.Padding(0, 0, 5, 0);
			this.btn_clients.Size = new System.Drawing.Size(194, 49);
			this.btn_clients.TabIndex = 3;
			this.btn_clients.Text = "Clientes";
			this.btn_clients.TextAlign = System.Drawing.ContentAlignment.MiddleRight;
			this.btn_clients.UseVisualStyleBackColor = true;
			// 
			// btn_delivery
			// 
			this.btn_delivery.Cursor = System.Windows.Forms.Cursors.Hand;
			this.btn_delivery.FlatAppearance.BorderSize = 0;
			this.btn_delivery.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
			this.btn_delivery.Font = new System.Drawing.Font("Century Gothic", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			this.btn_delivery.ForeColor = System.Drawing.Color.White;
			this.btn_delivery.Location = new System.Drawing.Point(4, 114);
			this.btn_delivery.Name = "btn_delivery";
			this.btn_delivery.Padding = new System.Windows.Forms.Padding(0, 0, 5, 0);
			this.btn_delivery.Size = new System.Drawing.Size(194, 49);
			this.btn_delivery.TabIndex = 2;
			this.btn_delivery.Text = "Encomendas";
			this.btn_delivery.TextAlign = System.Drawing.ContentAlignment.MiddleRight;
			this.btn_delivery.UseVisualStyleBackColor = true;
			// 
			// label1
			// 
			this.label1.AutoSize = true;
			this.label1.Font = new System.Drawing.Font("Century Gothic", 14.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			this.label1.ForeColor = System.Drawing.Color.White;
			this.label1.Location = new System.Drawing.Point(12, 33);
			this.label1.Name = "label1";
			this.label1.Size = new System.Drawing.Size(61, 23);
			this.label1.TabIndex = 0;
			this.label1.Text = "Menu";
			// 
			// btn_dashboard
			// 
			this.btn_dashboard.Cursor = System.Windows.Forms.Cursors.Hand;
			this.btn_dashboard.FlatAppearance.BorderSize = 0;
			this.btn_dashboard.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
			this.btn_dashboard.Font = new System.Drawing.Font("Century Gothic", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			this.btn_dashboard.ForeColor = System.Drawing.Color.White;
			this.btn_dashboard.Location = new System.Drawing.Point(4, 59);
			this.btn_dashboard.Name = "btn_dashboard";
			this.btn_dashboard.Padding = new System.Windows.Forms.Padding(0, 0, 5, 0);
			this.btn_dashboard.Size = new System.Drawing.Size(194, 49);
			this.btn_dashboard.TabIndex = 1;
			this.btn_dashboard.Text = "Painel de Controlo";
			this.btn_dashboard.TextAlign = System.Drawing.ContentAlignment.MiddleRight;
			this.btn_dashboard.UseVisualStyleBackColor = true;
			this.btn_dashboard.Click += new System.EventHandler(this.btn_dashboard_Click);
			// 
			// lb_action
			// 
			this.lb_action.Font = new System.Drawing.Font("Century Gothic", 14.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			this.lb_action.ForeColor = System.Drawing.Color.White;
			this.lb_action.Location = new System.Drawing.Point(245, 33);
			this.lb_action.Name = "lb_action";
			this.lb_action.Size = new System.Drawing.Size(322, 23);
			this.lb_action.TabIndex = 9;
			this.lb_action.Text = "Ação";
			this.lb_action.TextAlign = System.Drawing.ContentAlignment.MiddleLeft;
			// 
			// panel5
			// 
			this.panel5.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this.panel5.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(25)))), ((int)(((byte)(25)))), ((int)(((byte)(25)))));
			this.panel5.Location = new System.Drawing.Point(207, 80);
			this.panel5.Name = "panel5";
			this.panel5.Size = new System.Drawing.Size(792, 3);
			this.panel5.TabIndex = 4;
			// 
			// panel2
			// 
			this.panel2.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(234)))), ((int)(((byte)(166)))), ((int)(((byte)(57)))));
			this.panel2.Dock = System.Windows.Forms.DockStyle.Left;
			this.panel2.Location = new System.Drawing.Point(200, 0);
			this.panel2.Name = "panel2";
			this.panel2.Size = new System.Drawing.Size(7, 600);
			this.panel2.TabIndex = 1;
			// 
			// panel_move
			// 
			this.panel_move.Location = new System.Drawing.Point(207, 0);
			this.panel_move.Name = "panel_move";
			this.panel_move.Size = new System.Drawing.Size(792, 80);
			this.panel_move.TabIndex = 15;
			// 
			// pic_min
			// 
			this.pic_min.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
			this.pic_min.Cursor = System.Windows.Forms.Cursors.Hand;
			this.pic_min.Image = global::gymfit_app.Properties.Resources.straight_line;
			this.pic_min.Location = new System.Drawing.Point(936, 20);
			this.pic_min.Name = "pic_min";
			this.pic_min.Size = new System.Drawing.Size(20, 20);
			this.pic_min.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom;
			this.pic_min.TabIndex = 12;
			this.pic_min.TabStop = false;
			this.pic_min.Click += new System.EventHandler(this.pic_min_Click);
			// 
			// pic_close
			// 
			this.pic_close.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
			this.pic_close.Cursor = System.Windows.Forms.Cursors.Hand;
			this.pic_close.Image = global::gymfit_app.Properties.Resources.cancel;
			this.pic_close.Location = new System.Drawing.Point(968, 12);
			this.pic_close.Name = "pic_close";
			this.pic_close.Size = new System.Drawing.Size(20, 20);
			this.pic_close.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom;
			this.pic_close.TabIndex = 11;
			this.pic_close.TabStop = false;
			this.pic_close.Click += new System.EventHandler(this.pic_close_Click);
			// 
			// uc_mensalidades1
			// 
			this.uc_mensalidades1.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this.uc_mensalidades1.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			this.uc_mensalidades1.Location = new System.Drawing.Point(207, 83);
			this.uc_mensalidades1.Name = "uc_mensalidades1";
			this.uc_mensalidades1.Size = new System.Drawing.Size(792, 511);
			this.uc_mensalidades1.TabIndex = 9;
			// 
			// uc_dashboard1
			// 
			this.uc_dashboard1.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this.uc_dashboard1.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			this.uc_dashboard1.Location = new System.Drawing.Point(207, 83);
			this.uc_dashboard1.Name = "uc_dashboard1";
			this.uc_dashboard1.Size = new System.Drawing.Size(792, 511);
			this.uc_dashboard1.TabIndex = 18;
			// 
			// uc_produtos1
			// 
			this.uc_produtos1.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this.uc_produtos1.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			this.uc_produtos1.Location = new System.Drawing.Point(207, 83);
			this.uc_produtos1.Name = "uc_produtos1";
			this.uc_produtos1.Size = new System.Drawing.Size(792, 511);
			this.uc_produtos1.TabIndex = 17;
			// 
			// uc_mensagens1
			// 
			this.uc_mensagens1.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this.uc_mensagens1.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			this.uc_mensagens1.Location = new System.Drawing.Point(207, 83);
			this.uc_mensagens1.Name = "uc_mensagens1";
			this.uc_mensagens1.Size = new System.Drawing.Size(792, 511);
			this.uc_mensagens1.TabIndex = 16;
			// 
			// cl_dragControl1
			// 
			this.cl_dragControl1.SelectControl = this.panel_move;
			// 
			// MainForm
			// 
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			this.ClientSize = new System.Drawing.Size(1000, 600);
			this.Controls.Add(this.uc_mensalidades1);
			this.Controls.Add(this.uc_dashboard1);
			this.Controls.Add(this.uc_produtos1);
			this.Controls.Add(this.uc_mensagens1);
			this.Controls.Add(this.pic_min);
			this.Controls.Add(this.pic_close);
			this.Controls.Add(this.panel5);
			this.Controls.Add(this.lb_action);
			this.Controls.Add(this.panel2);
			this.Controls.Add(this.panel1);
			this.Controls.Add(this.panel_move);
			this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.None;
			this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
			this.Name = "MainForm";
			this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
			this.Text = "GymFit";
			this.WindowState = System.Windows.Forms.FormWindowState.Maximized;
			this.Load += new System.EventHandler(this.MainForm_Load);
			this.panel1.ResumeLayout(false);
			this.panel1.PerformLayout();
			((System.ComponentModel.ISupportInitialize)(this.pic_status_on)).EndInit();
			((System.ComponentModel.ISupportInitialize)(this.pic_status_off)).EndInit();
			((System.ComponentModel.ISupportInitialize)(this.pic_min)).EndInit();
			((System.ComponentModel.ISupportInitialize)(this.pic_close)).EndInit();
			this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.Panel panel1;
        private System.Windows.Forms.Button btn_messages;
        private System.Windows.Forms.Button btn_montly;
        private System.Windows.Forms.Button btn_clients;
        private System.Windows.Forms.Button btn_delivery;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.Button btn_dashboard;
        private System.Windows.Forms.Button btn_settings;
        private System.Windows.Forms.Button btn_power;
        private System.Windows.Forms.PictureBox pic_status_off;
        private System.Windows.Forms.Label lb_username;
        private System.Windows.Forms.Panel panel3;
        private System.Windows.Forms.Panel panel4;
        private System.Windows.Forms.PictureBox pic_status_on;
        private System.Windows.Forms.Button btn_products;
        private System.Windows.Forms.Label lb_action;
		private System.Windows.Forms.Panel panel5;
		private System.Windows.Forms.PictureBox pic_close;
		private System.Windows.Forms.PictureBox pic_min;
        private System.Windows.Forms.Panel panel_selectedMenu;
        private System.Windows.Forms.Panel panel2;
        private System.Windows.Forms.Panel panel_move;
        private cl_dragControl cl_dragControl1;
		private uc_mensagens uc_mensagens1;
		private uc_produtos uc_produtos1;
		private uc_dashboard uc_dashboard1;
		private uc.uc_mensalidades uc_mensalidades1;
	}
}

