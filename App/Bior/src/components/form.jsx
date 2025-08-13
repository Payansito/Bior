import React, { useState, useEffect } from 'react';
import { TextInput, SafeAreaView, View, Button, StyleSheet, Text, TouchableWithoutFeedback, Keyboard, Alert } from 'react-native';
import * as Location from 'expo-location';
import axios from 'axios';
import { SelectList } from 'react-native-dropdown-select-list';

import COLORS from '../conts/colors';
import Input from './Input';

const API_BASE = 'http://192.168.1.3/Bior/api/index.php';

const LoginScreen = () => {
  const [currentDate, setCurrentDate] = useState(new Date());
  const [location, setLocation] = useState(null);
  const [reverseGeocodedAddress, setReverseGeocodedAddress] = useState(null);
  const [folio, setFolio] = useState('');
  const [aceiteLitros, setAceiteLitros] = useState('');
  const [selected, setSelected] = useState('');
  const [selectedPrecio, setSelectedPrecio] = useState('0.00');
  const [isPriceEditable, setIsPriceEditable] = useState(true);
  const [data, setData] = useState([]); 

  useEffect(() => {
    const timer = setInterval(() => setCurrentDate(new Date()), 1000);
    return () => clearInterval(timer);
  }, []);

  useEffect(() => {
    const getPermissions = async () => {
      const { status } = await Location.requestForegroundPermissionsAsync();
      if (status !== 'granted') {
        console.log('No se otorgaron permisos de ubicación');
        return;
      }
      const currentLocation = await Location.getCurrentPositionAsync({});
      setLocation(currentLocation);
    };
    getPermissions();
  }, []);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const resp = await axios.get(API_BASE);
        const payload = Array.isArray(resp.data) ? resp.data : [];
        setData(payload);
      } catch (err) {
        console.error('Error => ', err.message);
        setData([]);
      }
    };
    fetchData();
  }, []);

  useEffect(() => {
    if (!selected) {
      setSelectedPrecio('0.00');
      setIsPriceEditable(true);
      return;
    }
    const row = data.find(item => item?.nombre === selected);
    if (row) {
      const precioStr = String(row?.precio ?? '0.00');
      setSelectedPrecio(precioStr);
      setIsPriceEditable(precioStr === '0.00');
    } else {
      setSelectedPrecio('0.00');
      setIsPriceEditable(true);
    }
  }, [selected, data]);

  const formattedDate = `${currentDate.getDate()}/${currentDate.getMonth() + 1}/${currentDate.getFullYear()}`;
  const paradb = new Date().toISOString().split('T')[0];

  const reverseGeocode = async () => {
    if (!location) return;
    const addr = await Location.reverseGeocodeAsync({
      longitude: location.coords.longitude,
      latitude: location.coords.latitude,
    });
    if (addr.length > 0) setReverseGeocodedAddress(addr[0]);
  };

  const sendFormDataToAPI = async () => {
    try {
      const dataToSend = {
        fecha: paradb,
        cantidad: aceiteLitros,
        folio: folio ? parseInt(folio, 10) : '',
        cliente: selected,
        precio: selectedPrecio,
        locacion: reverseGeocodedAddress
          ? `${reverseGeocodedAddress.name ?? ''}, ${reverseGeocodedAddress.district ?? ''}, ${reverseGeocodedAddress.city ?? ''}, ${reverseGeocodedAddress.postalCode ?? ''}`.replace(/\s+,/g, '').trim()
          : 'Dirección no disponible',
      };

      const formBody = new URLSearchParams(dataToSend).toString();

      const resp = await axios.post(API_BASE, formBody, {
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      });

      if (resp.status === 200) {
        Alert.alert('Éxito', 'Los datos se guardaron correctamente.');
        setFolio('');
        setAceiteLitros('');
        setSelected('');
        setSelectedPrecio('0.00');
        setIsPriceEditable(true);
      } else {
        Alert.alert('Aviso', 'Espera unos segundos antes de mandarla de nuevo.');
      }
    } catch (err) {
      console.error('Error al enviar datos: ', err.message);
      Alert.alert('Error', 'No se pudo enviar la información.');
    }
  };

  const handleLocationUpdate = async () => {
    if (!location) {
      console.log('Ubicación no disponible. No se pueden enviar datos.');
      Alert.alert('Ubicación', 'Activa la ubicación antes de guardar.');
      return;
    }
    await reverseGeocode();
    sendFormDataToAPI();
  };

  const selectOptions = Array.isArray(data)
    ? data.map(item => ({ key: item.nombre, value: item.nombre }))
    : [];

  return (
    <TouchableWithoutFeedback onPress={Keyboard.dismiss}>
      <SafeAreaView>

        <TextInput
          placeholder="Fecha"
          value={formattedDate}
          editable={false}
          style={{ marginHorizontal: 149, fontWeight: '500', fontSize: 22, top: -30 }}
        />

        <View style={{ paddingHorizontal: 25, marginVertical: 3 }}>
          <Input
            keyboardType="numeric"
            iconName="file-document-outline"
            label="Folio"
            placeholder="Ingrese el folio"
            value={folio}
            onChangeText={setFolio}
          />
        </View>

        <View style={{ paddingHorizontal: 25, marginVertical: 3 }}>
          <Input
            keyboardType="numeric"
            iconName="currency-usd"
            label="Precio por litro"
            placeholder="Ingrese el precio manualmente"
            value={String(selectedPrecio)}
            onChangeText={setSelectedPrecio}
            editable={isPriceEditable}
          />
        </View>

        <View style={{ paddingHorizontal: 25, marginVertical: 3 }}>
          <Input
            keyboardType="numeric"
            iconName="hexadecimal"
            label="Cantidad de aceite en litros"
            placeholder="Ingrese la cantidad de aceite"
            value={aceiteLitros}
            onChangeText={setAceiteLitros}
          />
        </View>

        <View>
          <Text style={{ top: 10, paddingHorizontal: 25 }}>Cliente</Text>
          <SelectList
            setSelected={val => setSelected(val)}
            data={selectOptions}
            save="value"
            placeholder="Selecciona el cliente"
            search={false}
            inputStyles={{ color: COLORS.grey, fontSize: 20, fontWeight: '400' }}
            dropdownStyles={{ paddingHorizontal: 10, marginVertical: 10, margin: 25, backgroundColor: COLORS.light, borderRadius: 3 }}
            boxStyles={{ borderRadius: 0, paddingHorizontal: 25, marginVertical: 10, margin: 25, backgroundColor: COLORS.light }}
          />
        </View>

        <View style={[styles.ButtonContainer, { alignItems: 'center', marginHorizontal: 55, justifyContent: 'center', marginTop: 25 }]}>
          <Button
            title="Guardar registro"
            onPress={handleLocationUpdate}
            color={COLORS.green}
          />
        </View>

      </SafeAreaView>
    </TouchableWithoutFeedback>
  );
};

const styles = StyleSheet.create({
  ButtonContainer: {
    height: 55,
    backgroundColor: COLORS.light,
    flexDirection: 'row',
    paddingHorizontal: 15,
    borderWidth: 0.5,
  },
});

export default LoginScreen;
