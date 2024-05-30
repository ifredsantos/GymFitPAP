namespace gymfit_app
{
	partial class FormLogin
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
			this.components = new System.ComponentModel.Container();
			System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(FormLogin));
			this.label2 = new System.Windows.Forms.Label();
			this.btn_login = new System.Windows.Forms.Button();
			this.txt_psw = new System.Windows.Forms.TextBox();
			this.txt_username_email = new System.Windows.Forms.TextBox();
			this.pic_min = new System.Windows.Forms.PictureBox();
			this.pic_close = new System.Windows.Forms.PictureBox();
			this.circulaPB_formMainLoading = new CircularProgressBar.CircularProgressBar();
			this.timer1 = new System.Windows.Forms.Timer(this.components);
			this.lbLink_forgotPsw = new System.Windows.Forms.LinkLabel();
			this.panel_move = new System.Windows.Forms.Panel();
			this.cl_dragControl1 = new gymfit_app.cl_dragControl();
			((System.ComponentModel.ISupportInitialize)(this.pic_min)).BeginInit();
			((System.ComponentModel.ISupportInitialize)(this.pic_close)).BeginInit();
			this.SuspendLayout();
			// 
			// label2
			// 
			this.label2.AutoSize = true;
			this.label2.Font = new System.Drawing.Font("Century Gothic", 21.75F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			this.label2.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(234)))), ((int)(((byte)(166)))), ((int)(((byte)(57)))));
			this.label2.Location = new System.Drawing.Point(221, 83);
			this.label2.Name = "label2";
			this.label2.Size = new System.Drawing.Size(221, 36);
			this.label2.TabIndex = 9;
			this.label2.Text = "Acesso restrito";
			// 
			// btn_login
			// 
			this.btn_login.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			this.btn_login.Cursor = System.Windows.Forms.Cursors.Hand;
			this.btn_login.FlatAppearance.BorderColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			this.btn_login.FlatAppearance.BorderSize = 0;
			this.btn_login.FlatAppearance.MouseDownBackColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			this.btn_login.FlatAppearance.MouseOverBackColor = System.Drawing.Color.FromArgb(((int)(((byte)(20)))), ((int)(((byte)(20)))), ((int)(((byte)(20)))));
			this.btn_login.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
			this.btn_login.Font = new System.Drawing.Font("Century Gothic", 12F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			this.btn_login.ForeColor = System.Drawing.Color.White;
			this.btn_login.Location = new System.Drawing.Point(291, 252);
			this.btn_login.Name = "btn_login";
			this.btn_login.Size = new System.Drawing.Size(81, 32);
			this.btn_login.TabIndex = 7;
			this.btn_login.Text = "Entrar";
			this.btn_login.UseVisualStyleBackColor = false;
			this.btn_login.Click += new System.EventHandler(this.btn_login_Click);
			// 
			// txt_psw
			// 
			this.txt_psw.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			this.txt_psw.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
			this.txt_psw.Font = new System.Drawing.Font("Century Gothic", 12.25F);
			this.txt_psw.ForeColor = System.Drawing.Color.White;
			this.txt_psw.Location = new System.Drawing.Point(231, 177);
			this.txt_psw.Name = "txt_psw";
			this.txt_psw.PasswordChar = '*';
			this.txt_psw.Size = new System.Drawing.Size(201, 28);
			this.txt_psw.TabIndex = 6;
			this.txt_psw.Text = "admin";
			this.txt_psw.TextAlign = System.Windows.Forms.HorizontalAlignment.Center;
			// 
			// txt_username_email
			// 
			this.txt_username_email.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			this.txt_username_email.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
			this.txt_username_email.Font = new System.Drawing.Font("Century Gothic", 12.25F);
			this.txt_username_email.ForeColor = System.Drawing.Color.White;
			this.txt_username_email.Location = new System.Drawing.Point(194, 134);
			this.txt_username_email.Name = "txt_username_email";
			this.txt_username_email.Size = new System.Drawing.Size(274, 28);
			this.txt_username_email.TabIndex = 5;
			this.txt_username_email.Text = "Admin";
			this.txt_username_email.TextAlign = System.Windows.Forms.HorizontalAlignment.Center;
			// 
			// pic_min
			// 
			this.pic_min.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
			this.pic_min.Cursor = System.Windows.Forms.Cursors.Hand;
			this.pic_min.Image = global::gymfit_app.Properties.Resources.straight_line;
			this.pic_min.Location = new System.Drawing.Point(598, 20);
			this.pic_min.Name = "pic_min";
			this.pic_min.Size = new System.Drawing.Size(20, 20);
			this.pic_min.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom;
			this.pic_min.TabIndex = 14;
			this.pic_min.TabStop = false;
			this.pic_min.Click += new System.EventHandler(this.pic_min_Click);
			// 
			// pic_close
			// 
			this.pic_close.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
			this.pic_close.Cursor = System.Windows.Forms.Cursors.Hand;
			this.pic_close.Image = global::gymfit_app.Properties.Resources.cancel;
			this.pic_close.Location = new System.Drawing.Point(630, 12);
			this.pic_close.Name = "pic_close";
			this.pic_close.Size = new System.Drawing.Size(20, 20);
			this.pic_close.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom;
			this.pic_close.TabIndex = 13;
			this.pic_close.TabStop = false;
			this.pic_close.Click += new System.EventHandler(this.pic_close_Click);
			// 
			// circulaPB_formMainLoading
			// 
			this.circulaPB_formMainLoading.AnimationFunction = WinFormAnimation.KnownAnimationFunctions.Liner;
			this.circulaPB_formMainLoading.AnimationSpeed = 500;
			this.circulaPB_formMainLoading.BackColor = System.Drawing.Color.Transparent;
			this.circulaPB_formMainLoading.Font = new System.Drawing.Font("Microsoft Sans Serif", 72F, System.Drawing.FontStyle.Bold);
			this.circulaPB_formMainLoading.ForeColor = System.Drawing.Color.White;
			this.circulaPB_formMainLoading.InnerColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			this.circulaPB_formMainLoading.InnerMargin = 2;
			this.circulaPB_formMainLoading.InnerWidth = -1;
			this.circulaPB_formMainLoading.Location = new System.Drawing.Point(296, 304);
			this.circulaPB_formMainLoading.MarqueeAnimationSpeed = 2000;
			this.circulaPB_formMainLoading.Name = "circulaPB_formMainLoading";
			this.circulaPB_formMainLoading.OuterColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			this.circulaPB_formMainLoading.OuterMargin = -25;
			this.circulaPB_formMainLoading.OuterWidth = 8;
			this.circulaPB_formMainLoading.ProgressColor = System.Drawing.Color.FromArgb(((int)(((byte)(234)))), ((int)(((byte)(166)))), ((int)(((byte)(57)))));
			this.circulaPB_formMainLoading.ProgressWidth = 10;
			this.circulaPB_formMainLoading.SecondaryFont = new System.Drawing.Font("Century Gothic", 14.25F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(0)));
			this.circulaPB_formMainLoading.Size = new System.Drawing.Size(70, 70);
			this.circulaPB_formMainLoading.StartAngle = 270;
			this.circulaPB_formMainLoading.SubscriptColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			this.circulaPB_formMainLoading.SubscriptMargin = new System.Windows.Forms.Padding(0);
			this.circulaPB_formMainLoading.SubscriptText = "";
			this.circulaPB_formMainLoading.SuperscriptColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			this.circulaPB_formMainLoading.SuperscriptMargin = new System.Windows.Forms.Padding(0);
			this.circulaPB_formMainLoading.SuperscriptText = "";
			this.circulaPB_formMainLoading.TabIndex = 15;
			this.circulaPB_formMainLoading.TextMargin = new System.Windows.Forms.Padding(0, 2, 0, 0);
			this.circulaPB_formMainLoading.Value = 50;
			// 
			// timer1
			// 
			this.timer1.Tick += new System.EventHandler(this.timer1_Tick);
			// 
			// lbLink_forgotPsw
			// 
			this.lbLink_forgotPsw.AutoSize = true;
			this.lbLink_forgotPsw.Font = new System.Drawing.Font("Century Gothic", 9.75F);
			this.lbLink_forgotPsw.LinkColor = System.Drawing.Color.FromArgb(((int)(((byte)(234)))), ((int)(((byte)(166)))), ((int)(((byte)(57)))));
			this.lbLink_forgotPsw.Location = new System.Drawing.Point(240, 220);
			this.lbLink_forgotPsw.Name = "lbLink_forgotPsw";
			this.lbLink_forgotPsw.Size = new System.Drawing.Size(182, 17);
			this.lbLink_forgotPsw.TabIndex = 16;
			this.lbLink_forgotPsw.TabStop = true;
			this.lbLink_forgotPsw.Text = "Esqueceu-se da password?";
			this.lbLink_forgotPsw.TextAlign = System.Drawing.ContentAlignment.MiddleCenter;
			this.lbLink_forgotPsw.VisitedLinkColor = System.Drawing.Color.FromArgb(((int)(((byte)(234)))), ((int)(((byte)(166)))), ((int)(((byte)(57)))));
			// 
			// panel_move
			// 
			this.panel_move.Location = new System.Drawing.Point(0, 0);
			this.panel_move.Name = "panel_move";
			this.panel_move.Size = new System.Drawing.Size(878, 80);
			this.panel_move.TabIndex = 17;
			// 
			// cl_dragControl1
			// 
			this.cl_dragControl1.SelectControl = this.panel_move;
			// 
			// FormLogin
			// 
			this.AcceptButton = this.btn_login;
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(15)))), ((int)(((byte)(15)))), ((int)(((byte)(15)))));
			this.ClientSize = new System.Drawing.Size(662, 414);
			this.Controls.Add(this.lbLink_forgotPsw);
			this.Controls.Add(this.circulaPB_formMainLoading);
			this.Controls.Add(this.pic_min);
			this.Controls.Add(this.pic_close);
			this.Controls.Add(this.label2);
			this.Controls.Add(this.btn_login);
			this.Controls.Add(this.txt_psw);
			this.Controls.Add(this.txt_username_email);
			this.Controls.Add(this.panel_move);
			this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.None;
			this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
			this.Name = "FormLogin";
			this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
			this.Text = "Login";
			this.Load += new System.EventHandler(this.FormLogin_Load);
			((System.ComponentModel.ISupportInitialize)(this.pic_min)).EndInit();
			((System.ComponentModel.ISupportInitialize)(this.pic_close)).EndInit();
			this.ResumeLayout(false);
			this.PerformLayout();

		}

		#endregion

		private System.Windows.Forms.Label label2;
		private System.Windows.Forms.Button btn_login;
		private System.Windows.Forms.TextBox txt_psw;
		private System.Windows.Forms.TextBox txt_username_email;
		private System.Windows.Forms.PictureBox pic_min;
		private System.Windows.Forms.PictureBox pic_close;
        private CircularProgressBar.CircularProgressBar circulaPB_formMainLoading;
        private System.Windows.Forms.Timer timer1;
        private System.Windows.Forms.LinkLabel lbLink_forgotPsw;
        private System.Windows.Forms.Panel panel_move;
        private cl_dragControl cl_dragControl1;
    }
}