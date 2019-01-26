package com.shop.admin;

import android.app.Application;
import android.content.SharedPreferences;
import android.preference.PreferenceManager;

public class App extends Application {
	private static App instance;

	@Override
    public void onCreate() {
        super.onCreate();
		instance = this;
    }
	
	public static String getHOST(){
		String host = "192.168.100.14";
		return host;
	}
	public static String getWeb(){
		String web = "http://" + getHOST() + "/shop/mobile";
		return web;
	}
	public static String getDataString(String key){
		SharedPreferences prefs = PreferenceManager.getDefaultSharedPreferences(instance);
		String test = prefs.getString(key,"");
		return test;
	}

	public static boolean getDataBoolean(String key){
		SharedPreferences prefs = PreferenceManager.getDefaultSharedPreferences(instance);
		boolean test = prefs.getBoolean(key,false);
		return test;
	}

	public static void setDataBoolean(String key, boolean data){
		SharedPreferences prefs = PreferenceManager.getDefaultSharedPreferences(instance);
		SharedPreferences.Editor editor = prefs.edit();
		editor.putBoolean(key, data);
		editor.commit();
	}

	public static void setDataString(String key, String data){
		SharedPreferences prefs = PreferenceManager.getDefaultSharedPreferences(instance);
		SharedPreferences.Editor editor = prefs.edit();
		editor.putString(key, data);
		editor.commit();
	}
	
}
