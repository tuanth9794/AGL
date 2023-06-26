import React, {useRef,useEffect, useState } from 'react';
import { Button, Form, Input, Table, Divider, Tag,  Breadcrumb, Layout, Menu, theme, Select } from 'antd';

const { Header, Content, Footer } = Layout;
const columns = [
    {
        title: 'name',
        dataIndex: 'name',
        key: 'name',
        render: text => <a href="javascript:;">{text}</a>,
    },
    {
        title: 'Google rank',
        dataIndex: 'google_rank',
        key: 'google_rank',
    },
    {
        title: 'Google search',
        dataIndex: 'google_searches',
        key: 'google_searches',
    },
    {
        title: 'Yahoo rank',
        dataIndex: 'yahoo_rank',
        key: 'yahoo_rank',
    },
    {
        title: 'Yahoo search',
        dataIndex: 'yahoo_searches',
        key: 'yahoo_searches',
    },

];

const Index = () => {


    const [data, setData] = useState([]);
    const ref = useRef(null);



    const onFinish = (e) => {
        // e.preventDefault();
        const website = document.getElementById('website').value.toLowerCase();
        const keyword =  document.getElementById('keyword').value.toLowerCase().split('\n').join();;
        document.getElementsByTagName('button')[0].setAttribute("disabled", "disabled");

        async function fetchData() {
            const response = await fetch(
                `http://127.0.0.1:8000/api/keyword?keyword=${keyword}&website=${website}&token=__lkajsdfaiufekfjb`
            );
            if (!response.ok) {
                const error = `Vui lòng nhập chính xác dữ liệu: ${response.status}`;
                document.getElementById('error').innerHTML = error;
                document.getElementsByTagName('button')[0].removeAttribute("disabled");
            }
            const data = await response.json();
            setData(data);
            document.getElementsByTagName('button')[0].removeAttribute("disabled");

        }
        fetchData();

    };

    return (
        <Layout className="layout" style={{height: '100vh'}}>
            <Header style={{ display: 'flex', alignItems: 'center' }}>
                <div className="demo-logo" />
                <Menu
                    theme="dark"
                    mode="horizontal"
                    defaultSelectedKeys={['2']}
                    items={new Array(1).fill(null).map((_, index) => {
                        const key = index + 1;
                        return {
                            key,
                            label: `Project Check Rank SEO Google & Yahoo `,
                        };
                    })}
                />
            </Header>
            <Content style={{ padding: '0 50px',display: 'flex',flexDirection: 'column', justifyContent:'center',
            alignItems:'center'}}>
                <p id='error'></p>
               <Form
                   name="wrap"
                   labelCol={{ flex: '110px' }}
                   labelAlign="left"
                   labelWrap
                   wrapperCol={{ flex: 1 }}
                   colon={false}
                   style={{ maxWidth: '80%', width: '80%', marginBottom:'30px' }}
                   initialValues={{
                       remember: true
                   }}
                   onFinish={onFinish}
               >
                   <Form.Item label="URL" name="website" rules={[{ required: true, message: 'Link  website không thể để trống' }]}>
                       <Input id={'website'}/>
                   </Form.Item>

                   <Form.Item label="Keywords" name="keyword" rules={[{ required: true, message: 'Thêm ít nhất 1 từ khóa. Nhấn enter xuống dòng để thêm nhiều từ khóa ' }]}>
                       <Input.TextArea id={'keyword'} rows={5}/>
                   </Form.Item>
                   <Button type="primary" htmlType="submit"
                   style={{dispaly: 'flex',marginLeft: 'auto',marginRight:'auto'}}
                   >
                       Submit
                   </Button>
               </Form>

                <Table columns={columns} dataSource={data} scroll={{x: 768}} />
            </Content>
            <Footer style={{ textAlign: 'center' }}>Copyright © 2023 <a href={`https://creand.net`}></a>Creand</Footer>
        </Layout>
    )
}

export default Index
