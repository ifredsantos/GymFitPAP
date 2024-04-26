/*
 * Developed by Frederico Santos on 20-01-2019 4:31.
 * Last modified 20-01-2019 4:49.
 * Copyright (c) 2019. All rights reserved.
 */

package pt.ginasiogymfit.gymfitapp;

import android.content.Context;
import android.os.Handler;
import android.os.Vibrator;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.KeyEvent;
import android.view.View;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.webkit.WebSettings.RenderPriority;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.widget.Toast;
import android.app.AlertDialog;
import android.content.DialogInterface;

public class MainActivity extends AppCompatActivity {
    private WebView meuWebView;

    private void Vibrar()
    {
        Vibrator rr = (Vibrator) getSystemService(Context.VIBRATOR_SERVICE);
        long tempo = 100; // em milisegundos
        rr.vibrate(tempo);
    }

    Handler handler = new Handler();
    Runnable runnable = new Runnable() {
        @Override
        public void run() {
            meuWebView.setVisibility(View.VISIBLE);
            Vibrar();
        }
    };

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        setContentView(R.layout.activity_main);
        meuWebView = (WebView) findViewById(R.id.meuWebView);

        ConnectivityManager cm = (ConnectivityManager) this.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo activeNetwork = cm.getActiveNetworkInfo();
        if (activeNetwork != null && activeNetwork.isConnected()) {
            if (savedInstanceState != null) {
                meuWebView.setVisibility(View.VISIBLE);
                meuWebView.restoreState(savedInstanceState);
            } else {
                meuWebView.loadUrl("https://gymfit.fredinson.pt/login_registo_mobile.php");
            }

            meuWebView.setWebViewClient(new WebViewClient() {
                public void onPageFinished(WebView view, String url) {
                    if (url.contains("gymfit.fredinson.pt/login_registo_mobile.php"))
                        handler.postDelayed(runnable, 100);
                    else
                        meuWebView.setVisibility(View.VISIBLE);
                }
            });

            WebSettings webSettings = meuWebView.getSettings();
            meuWebView.setFocusable(true);
            meuWebView.setFocusableInTouchMode(true);
            meuWebView.getSettings().setJavaScriptEnabled(true);
            meuWebView.getSettings().setRenderPriority(RenderPriority.HIGH);
            meuWebView.getSettings().setCacheMode(WebSettings.LOAD_NO_CACHE);
            meuWebView.getSettings().setDomStorageEnabled(true);
            meuWebView.getSettings().setAppCacheEnabled(true);
            // força o uso do chromeWebClient
            meuWebView.getSettings().setSupportMultipleWindows(true);
        } else {
            AlertDialog.Builder builder = new AlertDialog.Builder(this);
            builder.setTitle("Sem conexão!");
            builder.setMessage("Não tem conexão à internet...\nConecte-se.").setCancelable(false)
                    .setPositiveButton("OK", new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int id) {
                            finish();
                        }
                    });
            AlertDialog alert = builder.create();
            alert.show();

            Toast.makeText(this,"O seu dispositivo não está conectado à internet, é recomendado o uso de 3G/4G ou Wifi ",Toast.LENGTH_LONG).show();

        }
    }

    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        if ((keyCode == KeyEvent.KEYCODE_BACK) && meuWebView.canGoBack()) {
            meuWebView.goBack();
            Vibrar();
            return true;
        }
        return super.onKeyDown(keyCode, event);
    }

    @Override
    protected void onSaveInstanceState(Bundle outState) {
        super.onSaveInstanceState(outState);
        meuWebView.saveState(outState);
    }
}