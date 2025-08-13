import React from 'react';
import {View, Text, TextInput, StyleSheet} from 'react-native';
import COLORS from '../conts/colors';
import Icon from 'react-native-vector-icons/MaterialCommunityIcons';
const Input = ({
  label,
  iconName,
  error,
  password,
  onFocus = () => {},
  ...props
}) => {
  const [isFocused, setIsFocused] = React.useState(false);
  return (
    <View>
      <Text style={style.label}>{label}</Text>
      <View
        style={[style.inputContainer, { alignItems: 'center'}]}>
        <Icon name={iconName} style={{color: COLORS.green, fontSize: 22, marginRight: 10}}/>
        <TextInput autoCorrect={false} onFocus={() => { onFocus(); setIsFocused(true); }}
          onBlur={() => setIsFocused(false)} style={{color: COLORS.green, flex: 1}} {...props}
        />
      </View>
    </View>
  );
};

const style = StyleSheet.create({
  inputContainer: {
    height: 55,
    backgroundColor: COLORS.light,
    flexDirection: 'row',
    paddingHorizontal: 15,
    borderWidth: 0.5,
  },
});

export default Input;