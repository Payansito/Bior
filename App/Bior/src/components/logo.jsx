import React from "react"
import {Image, SafeAreaView, StyleSheet} from "react-native";

function Logo() {
    return(
        <SafeAreaView>
            <Image style = {style.container} source={require("../assets/logo.png")}/>
        </SafeAreaView>
    );
};

const style = StyleSheet.create({
    container: {
        marginTop: 30,
        margin: 80
    }
})

export default Logo