package com.example.garfil;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageButton;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageButton;

public class products extends AppCompatActivity {
    ImageButton imgbtn, imgbtn1, imgbtn2, imgbtn3, imgbtn4, imgbtn5;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.products);


        imgbtn = (ImageButton) findViewById(R.id.img1);
        imgbtn1 = (ImageButton) findViewById(R.id.img6);
        imgbtn2 = (ImageButton) findViewById(R.id.img2);
        imgbtn3 = (ImageButton) findViewById(R.id.img3);
        imgbtn4 = (ImageButton) findViewById(R.id.img4);
        imgbtn5 = (ImageButton) findViewById(R.id.img5);

        imgbtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(products.this, sandals.class));
            }
        });
        imgbtn1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(products.this, shorts.class));
            }
        });
        imgbtn2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(products.this, hats.class));
            }
        });
        imgbtn3.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(products.this, pants.class));
            }
        });
        imgbtn4.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(products.this, shirts.class));
            }
        });
        imgbtn5.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(products.this, shoes.class));
            }
        });


    }
}